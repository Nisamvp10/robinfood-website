 <?php  $totalCartAMount = 0;?>
<div class="cart-box " id="cartBox">
    <ul>
        <?php
        if(!empty($result)) {
          
            foreach($result as $row) {
                ?>
            <li>
                <a href="<?=base_url('product-details/'.$row['slug'])?>">
                    <img
                        src="<?=validImg($row['image'])?>" alt="image"/>
                </a>
            <div class="cart-product w-100 d-flex align-items-center justify-content-between">
                <div class=" w-100 ">
                    <a href="<?=base_url('product-details/'.$row['slug'])?>" class="d-flex justify-content-between" ><?=$row['product_title']?> </a>
                    <span><?= money_format_custom($row['price'])?>  X <?=$row['quantity']?></span> 
                </div>
                <div class="cart-delete">
                    <span class="remove-from-cart" data-id="<?=$row['product_id']?>"><i class="fa fa-trash"></i></span>
                </div>
            </div>
        </li>
    <?php
        $totalCartAMount += $row['price'] * $row['quantity'];
            }
        }
    ?>
    </ul>
    <div class="shopping-items d-flex align-items-center justify-content-between">
        <!-- <span>Shopping : Rs 20.00</span> -->
        <span>Total : <?=money_format_custom($totalCartAMount)?></span>
    </div>
    <div class="cart-button d-flex justify-content-between mb-4">
        <a href="<?=base_url('cart')?>" class="theme-btn">View Cart</a>
        <a href="<?=base_url('checkout')?>" class="theme-btn bg-red-2">Checkout</a>
    </div>
</div>
<a href="<?=base_url('cart')?>" class="cart-icon" >
   <i class="fa-regular fa-bag-shopping"></i>
   <span id="cartCount"><?=count($result)??0?></span>
</a>