  <?php
    if ($result) {
        $qty = 1;
        $total = 0;
        ?>
        <form method="post" id="cartForm">
    <div class="table_desc">
        <div class="table_page table-responsive">
            <table>
              
                <tbody>
                    <!-- Start Cart Single Item-->

                  <?php
                        foreach ($result as $row) {
                    ?>
                            <tr>
                                <td class="product_thumb d-flex align-items-center justify-content-between">
                                    <a href="#!">
                                        <img src="<?= validImg($row['image']) ?>" alt="img"></a>
                                    <a class="product-name" href="#!"><?= $row['product_title'] ?>
                                    <input type="hidden" value="<?= encryptor($row['id']) ?>"  name="item_id[]" />
                                </a>
                                </td>
                                <td class="product-price"><?= money_format_custom($row['price']) ?> </td>
                                <td class="product_quantity">
                                    <div class="plus-minus-input">
                                        <div class="input-group-button">
                                            <button type="button" class="button" onclick="minusCartQty(this)" data-quantity="minus"
                                                data-field="itemQty<?= $qty ?>">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <input class="form-control" type="number" id="itemQty<?= $qty ?>" name="quantity[]" value="<?= $row['quantity'] ?>">
                                        <div class="input-group-button">
                                            <button type="button" class="button" onclick="plusCartQty(this)" data-quantity="plus"
                                                data-field="itemQty<?= $qty ?>">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="product_total"><?= money_format_custom($row['price'] * $row['quantity']) ?></td>
                                <td class="productremove" ><a class="removeFromCart" data-id="<?=$row['product_id']?>"  href="#"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <g clip-path="url(#clip0_229_10585)">
                                                <path
                                                    d="M12 23C18.0748 23 23 18.0748 23 12C23 5.92525 18.0748 1 12 1C5.92525 1 1 5.92525 1 12C1 18.0748 5.92525 23 12 23Z"
                                                    stroke="#E5E5E5" stroke-miterlimit="10" />
                                                <path d="M16 8L8 16" stroke="#5F5F5F" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M16 16L8 8" stroke="#5F5F5F" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_229_105852244">
                                                    <rect width="24" height="24" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg></a></td>
                            </tr>
                    <?php $qty++;
                        }
                     ?>
                    <!-- End Cart Single Item-->
                    <!-- Start Cart Single Item-->

                </tbody>
            </table>
        </div>
    </div>
    <div class="coupon-inner">
     
        <div class="coupon-right">
            <div class="cart_submit">
                <button class="theme-btn style6" type="submit">update cart</button>
            </div>
        </div>
    </div>

</form>
<?php
} else {
    echo "<p>No items in cart</p>";
}
?>