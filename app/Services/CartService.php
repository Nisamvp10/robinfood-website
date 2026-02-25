<?php
namespace App\Services;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductManageModel;
class CartService
{
    protected $cartModel;
    protected $itemModel;
    protected $productModel;
    protected $categoryModel;
    protected $productManageModel;
    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->itemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productManageModel = new ProductManageModel();
    }
    public function getMyCart()
    {
        $session = session();

        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }

        $sessionId = $session->get('cart_session') ?? session_id();
        $session->set('cart_session', $sessionId);

        if ($userId) {
            $cart = $this->cartModel->where('user_id', $userId)->first();
            if ($cart) {
                return $cart;
            }
        }

        return $this->cartModel->where('session_id', $sessionId)->first();
    }

    private function getCart()
    {
        $session = session();

        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }

        $sessionId = $session->get('cart_session') ?? session_id();
        $session->set('cart_session', $sessionId);

        if ($userId) {
            $cart = $this->cartModel->where('user_id', $userId)->first();
            if ($cart) {
                return $cart;
            }
        }

        return $this->cartModel->where('session_id', $sessionId)->first();
    }

     private function createCart()
    {
        $session = session();
        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }
        return $this->cartModel->insert([
            'user_id'    => $userId,
            'session_id' => $session->get('cart_session'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

   public function add($data)
    {
        $productId = $data['product_id'] ?? null;
        $qty       = max(1, (int)($data['qty'] ?? 1));

        $product = $this->productManageModel->find($productId);
        $stockItem = $this->productModel->find($product['product_id']);
        if (!$product || $stockItem['current_stock'] < $qty) {
            return ['status' => false, 'message' => 'Out of stock'];
        }

        $productPrice =  calculatePrice(
                    $product['price'],
                    $product['compare_price'],
                    $product['price_offer_type']
            );
            
            $offerPrice  = $productPrice['offer_price'];
            $discount    = $productPrice['discount'];
            $actualPrice = $productPrice['actual_price'];

        $cart = $this->getCart();
        $cartId = $cart['id'] ?? $this->createCart();

        $item = $this->itemModel
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        $newQty = $item ? $item['quantity'] + $qty : $qty;

        if ($newQty > $stockItem['current_stock']) {
            return ['status' => false, 'message' => 'Stock exceeded'];
        }

        if ($item) {
            $this->itemModel->update($item['id'], [
                'quantity' => $newQty,
                'subtotal' => $newQty * $offerPrice,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->itemModel->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'price' => $offerPrice,
                'quantity' => $qty,
                'subtotal' => $qty * $offerPrice
            ]);
        }

        return [
            'status' => true,
            'message' =>'Added to cart',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cartId)
                ->countAllResults()
        ];
    }

    public function remove($data)
    {
        $productId = $data['product_id'] ?? null;

        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $item = $this->itemModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->first();
            //echo $this->itemModel->getLastQuery();

        if (!$item) {
            return ['status' => false, 'message' => 'Item not found in cart'];
        }

        $this->itemModel->delete($item['id']);

        return [
            'status' => true,
            'message' => 'Item removed successfully',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cart['id'])
                ->countAllResults()
        ];
    }

    public function update(array $data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        if (!isset($data['item_id']) || !isset($data['quantity'])) {
            return ['status' => false, 'message' => 'Invalid request'];
        }

        $itemIds   = $data['item_id'];
        $quantities = $data['quantity'];

        $total = 0;

        foreach ($itemIds as $index => $itemId) {
            $itemId = decryptor($itemId);
            $qty = (int) $quantities[$index];

            if ($qty < 1) {
                $this->itemModel->delete($itemId);
                continue;
            }

            $item = $this->itemModel
                ->where('id', $itemId)
                ->where('cart_id', $cart['id'])
                ->first();

            if (!$item) continue;

            $productmanage = $this->productManageModel->find($item['product_id']);
            $product = $this->productModel->find( $productmanage['product_id']);

            if (!$productmanage || $qty > $product['current_stock']) {
                return [
                    'status' => false,
                    'message' => 'Stock exceeded for ' . $productmanage['product_title']
                ];
            }

            $subtotal = $qty * $item['price'];

            $this->itemModel->update($itemId, [
                'quantity' => $qty,
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        return [
            'status' => true,
            'message' => 'Cart updated successfully',
            'total' => $total
        ];
    }


    

    public function getCartItems()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return [];
        }

        $items = $this->itemModel->where('cart_id', $cart['id'])->findAll();

        if (empty($items)) {
            return [];
        }
        // Products
        $productIds = array_column($items, 'product_id');
        if (empty($productIds)) {
            return [];
        }

        $products = $this->productManageModel->whereIn('id', $productIds)->findAll();
        $products = array_column($products, null, 'id');

        // Categories
        $categoryIds = array_unique(array_column($products, 'category_id'));

        if (!empty($categoryIds)) {
            $categories = $this->categoryModel
                ->whereIn('id', $categoryIds)
                ->findAll();
            $categories = array_column($categories, null, 'id');
        } else {
            $categories = [];
        }

        // Build cart response
        $cartItems = [];

        foreach ($items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) continue;

            $category = $categories[$product['category_id']] ?? null;

            $cartItems[] = [
                'id'            => $item['id'],
                'product_id'    => $item['product_id'],
                'product_title' => $product['product_title'],
                'category_name' => $category['category'] ?? null,
                'price'         => $item['price'],
                'quantity'      => $item['quantity'],
                'subtotal'      => $item['subtotal'],
                'image'         => $product['product_image']
            ];
        }

        return $cartItems;
    }
    public function deleteCart($data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $this->cartModel->where('id', $cart['id'])->delete();

        return [
            'status' => true,
            'message' => 'Cart deleted successfully'
        ];
    }

}