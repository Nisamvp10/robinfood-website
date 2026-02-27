<?php
    $couponDiscount = 0;

    if(isset($cartdata) && $cartdata != null) {
        $couponDiscount = ($cartdata['coupon_discount'] ==0)?0:$cartdata['coupon_discount'] ?? 0;
    }
    $amountAmt = 0;
    $taxAmt = getappdata('tax');
    if($subtotal)   {
        foreach($subtotal as $res) {
            $amountAmt += $res['subtotal'];  
        }
    }    
    $taxCalculate = round($amountAmt * ($taxAmt / 100));
    $totalAmt = $amountAmt + $taxCalculate - $couponDiscount;
    ?>

<div class="cart-checkout-wrapper w-100 mb-0 border w-100 mt-0" style="w-100">
            <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                <h3 class="p-10 bg-off-white py-3 px-2">Order Summary  (<?= count($subtotal) ?>)</h3>
                <div class="coupon_inner p-2">
                    <div class="cart-subtotal">
                        <p>Subtotal</p>
                        <p class="cart_amount"><?= money_format_custom($amountAmt) ?></p>
                    </div>
                  
                       <div class="coupon-left mt-2">
                            <div class="coupon-input d-flex align-items-center mt-3 mb-3">
                                <input class="couponcodeInput" placeholder="Coupon code" class="h-auto " type="text">
                                <button type="button" class="theme-btn style6 applyCoupon rounded-0 h-auto px-3 py-2">Apply</button>
                            </div>
                        </div>
                        
                        <?php if($couponDiscount > 0) { ?>
                        <div class="cart_subtotal d-flex align-items-center justify-content-between">
                            <p>Coupon Discount</p>
                            <p class="cart_amount"><?= money_format_custom($couponDiscount) ?></p>
                        </div>
                        <?php } ?>
                        <div class="cart_subtotal d-flex align-items-center justify-content-between mt-3 mb-3">
                            <p>Tax</p>
                            <p class="cart_amount"><?= money_format_custom($taxCalculate) ?></p>
                        </div>
                        

                    <div class="cart-subtotal">
                        <p>Total</p>
                        <p class="cart_amount"><?= money_format_custom($totalAmt) ?></p> 
                    </div>
                    <div class="checkout-btn">
                        <a href="javascript:void(0)" class="theme-btn style6 checkoutBtn">Place Order <?=money_format_custom($totalAmt)?></a>
                    </div>
                </div>
            </div>
        </div>