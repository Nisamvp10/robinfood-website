<style>
    .cart-card{
    display:flex;
    gap:25px;
    background:#fff;
    border:1px solid #e9e9e9;
    border-radius:12px;
    padding:10px;
    margin-bottom:20px;
    transition:.3s;
}

.cart-card:hover{
    box-shadow:0 8px 30px rgba(0,0,0,.08);
}

.cart-image{
    width:180px;
    flex-shrink:0;
}

.cart-image img{
    width:100%;
    height:170px;
    padding:10px;
    object-fit:fill;
    border-radius:10px;
    border:1px solid #eee;
}

.cart-details{
    flex:1;
    display:flex;
    flex-direction:column;
}

.product-title{
    font-size:24px;
    margin-bottom:0;
}

.product-title a{
    color:#222;
    text-decoration:none;
}

.product-title a:hover{
    color:#0d6efd;
}

.cart-info{
    width:100%;
}

.cart-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:5px 0;
    border-bottom:1px dashed #eee;
}

.cart-row span{
    color:#777;
    font-weight:500;
}

.cart-row strong{
    font-size:18px;
}

.plus-minus-input{
    display:flex;
    align-items:center;
    border:1px solid #ddd;
    border-radius:30px;
    overflow:hidden;
}

.plus-minus-input button{
    width:40px;
    height:40px;
    border:none;
    background:#f5f5f5;
    font-size:18px;
}

.plus-minus-input button:hover{
    background:#0d6efd;
    color:#fff;
}

.plus-minus-input input{
    width:65px;
    text-align:center;
    border:none;
    outline:none;
    font-weight:600;
}

.cart-footer{
    display:flex;
    justify-content:flex-end;
    margin-top:20px;
}

.removeFromCart{
    font-weight:600;
    text-decoration:none;
}

.removeFromCart:hover{
    color:red;
}

@media(max-width:991px){

.cart-card{
    flex-direction:column;
}

.cart-image{
    width:100%;
    text-align:center;
}

.cart-image img{
    width:220px;
    height:220px;
}

.cart-row{
    flex-direction: row;
    align-items: flex-start;
    gap: 10px;
    justify-content: space-between;
}

.cart-footer{
    justify-content:flex-start;
}

}

@media(max-width:576px){

.cart-card{
    padding:15px;
}

.product-title{
    font-size:18px;
}

.cart-image img{
    width:170px;
    height:170px;
}

.plus-minus-input input{
    width:50px;
}

}
</style>

<?php if ($result) { ?>

<form method="post" id="cartForm">

<?php
$qty = 1;
foreach ($result as $row) {
?>

<div class="cart-card">

    <!-- Product Image -->
    <div class="cart-image">
        <a href="<?= base_url('product-details/'.$row['slug']) ?>">
            <img src="<?= validImg($row['image']) ?>" alt="<?= $row['product_title'] ?>">
        </a>
    </div>

    <!-- Product Details -->
    <div class="cart-details">

        <h4 class="product-title">
            <a href="<?= base_url('product-details/'.$row['slug']) ?>">
                <?= $row['product_title'] ?>
            </a>
        </h4>

        <div class="cart-info">

            <div class="cart-row">
                <span>Price</span>
                <strong><?= money_format_custom($row['price']) ?></strong>
            </div>

            <div class="cart-row">
                <span>Quantity</span>

                <div class="plus-minus-input">

                    <button type="button"
                        onclick="minusCartQty(this)"
                        data-field="itemQty<?= $qty ?>">
                        <i class="fa fa-minus"></i>
                    </button>

                    <input
                        class="form-control"
                        type="number"
                        id="itemQty<?= $qty ?>"
                        name="quantity[]"
                        value="<?= $row['quantity'] ?>">

                    <button type="button"
                        onclick="plusCartQty(this)"
                        data-field="itemQty<?= $qty ?>">
                        <i class="fa fa-plus"></i>
                    </button>

                </div>
            </div>

            <div class="cart-row">
                <span>Total</span>
                <strong class="text-success">
                    <?= money_format_custom($row['price'] * $row['quantity']) ?>
                </strong>
            </div>

        </div>

        <div class="cart-footer">

            <a href="#"
                class="removeFromCart text-danger"
                data-id="<?= $row['product_id'] ?>">
                <i class="fa fa-trash"></i> Remove
            </a>

        </div>

        <input type="hidden"
            name="item_id[]"
            value="<?= encryptor($row['id']) ?>">

    </div>

</div>

<?php $qty++; } ?>

<div class="text-end mt-4 d-none">
    <button class="theme-btn style6" type="submit">
        Update Cart
    </button>
</div>

</form>

<?php } else { ?>

<div class="text-center py-5">

    <img src="<?= base_url('assets/images/empty-cart.png') ?>"
         style="width:180px;">

    <h4 class="mt-4">Your Cart is Empty</h4>

</div>

<?php } ?>