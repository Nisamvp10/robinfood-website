<?= view('frontend/inc/header') ?>

<!-- Search Area Start -->
<div class="search-wrap">
    <div class="search-inner">
        <i class="fas fa-times search-close" id="search-close"></i>
        <div class="search-cell">
            <form method="get">
                <div class="search-field-holder">
                    <input
                        type="search"
                        class="main-search-input"
                        placeholder="Search..." />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="breadcumb-section">
    <div
        class="breadcumb-container-wrapper"
        data-bg-src="<?= base_url('public/assets/template/'); ?>assets/images/breadcumb/breadcumb-bg.png">
        <div class="shape1">
            <img
                src="<?= base_url('public/assets/template/'); ?>assets/img/breadcumb-shape1_1.png"
                alt="shape" />
        </div>
        <div class="shape2">
            <img
                src="<?= base_url('public/assets/template/'); ?>assets/img/breadcumb-shape1_2.png"
                alt="shape" />
        </div>
        <div class="shape3">
            <img
                src="<?= base_url('public/assets/template/'); ?>assets/img/breadcumb-shape1_3.png"
                alt="shape" />
        </div>
        <div class="shape4">
            <img
                src="<?= base_url('public/assets/template/'); ?>assets/img/breadcumb-shape1_4.png"
                alt="shape" />
        </div>
        <div class="container">
            <ul class="breadcumb-wrapper">
                <li>
                    <a href="index.html"><i class="fa-sharp fa-light fa-house"></i></a>
                </li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li>Products</li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li>checkout</li>
            </ul>
        </div>
    </div>
</div>


<div class="checkout-wrapper section-padding fix">
    <div class="container">
            <div class="row ">
                <div class="col-lg-8  col-sm-12">


                    <!--  -->
                    <div id="accordion">
                        <div class="card mb-3">
                            <button class="card-header border collapsed card-link bg-white d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseaddress">

                                <b class="header-title float-left">
                                    Shipping Info
                                </b>
                                <i class="fa fa-plus float-right "></i>
                            </button>

                            <div id="collapseaddress" class="collapse show"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div id="shippingAddress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <button class="card-header  border collapsed card-link bg-white d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseTwo">

                                <div class="header-title float-left">
                                    <b class="header-title float-left">
                                        Shopping Cart
                                    </b>
                                </div>
                                <i class="fa fa-plus float-right "></i>
                            </button>

                            <div id="collapseTwo" class="collapse"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="course-terms cart" id="cartItems"></div> <!-- course terms -->
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <button class="card-header collapsed card-link d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseThree">

                                <b class="header-title float-left">
                                    Purchase History
                                </b>
                                <i class="fa fa-plus float-right "></i>

                            </button>
                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table">
                                        <?php
                                        if (!empty($getorderHistory)) { ?>
                                            <thead>
                                                <tr>
                                                    <td>Code</td>
                                                    <td>date</td>
                                                    <td>Amount</td>
                                                    <td>Delivery Status</td>
                                                    <td>Payment Status</td>
                                                    <td>Optopn</td>
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($getorderHistory as $myorder) { ?>

                                                <tr>
                                                    <td><?= $myorder->code; ?></td>
                                                    <td><?= date('Y-m-d', $myorder->date); ?></td>
                                                    <td><?= number_format($myorder->grand_total); ?></td>
                                                    <td><?= $myorder->delivery_status; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($myorder->payment_status == "paid") {
                                                            echo '<label class="label label-success label-sm">paid</label>';
                                                        } ?>
                                                    </td>
                                                    <td class="d-flex">
                                                        <a class="badge label-danger deleteOrder" onclick="deleteorder()" href=":void(0)"><i class="fa fa-trash"></i></a>
                                                        <a class="badge label-success deleteOrder" href="<?= site_url('history-details/' . encryptor($myorder->id)); ?>"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="" id="cartSubtotal"> </div>
                </div>
            </div>
        
        <h4 class="mb-4">Your Order</h4>
        
        <div class="mt-lg-3 mb-30">
            <div class="woocommerce-checkout-payment">
                <ul class="wc_payment_methods payment_methods methods">
                    <li class="wc_payment_method payment_method_bacs">
                        <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method"
                            value="bacs" checked="checked">
                        <label for="payment_method_bacs">Direct bank transfer</label>
                        <div class="payment_box payment_method_bacs">
                            <p>Make your payment directly into our bank account. Please use your Order ID as the
                                payment reference. Your order will not be shipped until the funds have cleared in
                                our account.
                            </p>
                        </div>
                    </li>
                    <li class="wc_payment_method payment_method_cheque">
                        <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method"
                            value="cheque">
                        <label for="payment_method_cheque">Cheque Payment</label>
                        <div class="payment_box payment_method_cheque">
                            <p>Please send a check to Store Name, Store Street, Store Town, Store State / County,
                                Store Postcode.</p>
                        </div>
                    </li>
                    <li class="wc_payment_method payment_method_cod">
                        <input id="payment_method_cod" type="radio" class="input-radio" name="payment_method">
                        <label for="payment_method_cod">Credit Cart <img src="<?= base_url('public/assets/template/'); ?>assets/images/credit_card.jpg"
                                alt="image"></label>
                        <div class="payment_box payment_method_cod">
                            <p>Pay with cash upon delivery.</p>
                        </div>
                    </li>
                    <li class="wc_payment_method payment_method_paypal">
                        <input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method"
                            value="paypal">
                        <label for="payment_method_paypal">Paypal<img src="<?= base_url('public/assets/template/'); ?>assets/images/paypal.jpg"
                                alt="PayPal acceptance mark"></label>
                        <div class="payment_box payment_method_paypal">
                            <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.
                            </p>
                        </div>
                    </li>
                </ul>
        
            </div>
        </div>
    </div>
</div>



    <!--  -->

    <?= view('modal/shippingAddressModal')?>
    <?= view('modal/loginModal')?>
    <?= view('frontend/inc/footerLink') ?>
    <!-- REQUIRED JS ORDER -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/count.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/auth.js"></script>
    <script src="<?=base_url('public/assets/template/');?>assets/js/checkout.js"></script>

<script>
    mycart();

    function mycart(){
      
        $.ajax({
            url: "<?=base_url('cart/checkout-items');?>",
            method: "POST",
            success: function (response) {
                $('#cartItems').html(response.res);
                $('#cartSubtotal').html(response.subtotal);
            }
        });
    }


   $(document).on('submit','#cartForm', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.ajax({
        url: App.getSiteurl() + "cart/update",
        method: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            if (data.status) {
                toastr.success(data.message);
                cartNotification();
                mycart();
            } else {
                toastr.error(data.message);
            }
        }
    });
});

document.addEventListener('click', async (e) => {

    /* ================= REMOVE FROM CART ================= */
    if (e.target.closest('.removeFromCart')) {
        const btn = e.target.closest('.removeFromCart');
        const productId = btn.dataset.id;

        const response = await fetch(App.getSiteurl() + "cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);

            // remove item from UI
            document.querySelector(`.cart-item[data-id="${productId}"]`)?.remove();

            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
            mycart();
        } else {
            toastr.error(data.message);
        }
    }

});



</script>
<!-- intlTelInput CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
<!-- intlTelInput JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<!-- Utils (required for validation) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script>
$(document).ready(function () {
    const input = document.querySelector("#shipping_phone") ?? null;
    if (!input) return;
    // Initialize intlTelInput and store instance in `iti`
    const iti = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "in",
        preferredCountries: ["in"],
        nationalMode: false,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    const errorMsg = $("#error-msg");
    const validMsg = $("#valid-msg");

    function reset() {
        errorMsg.hide();
        validMsg.hide();
    }

    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                const countryData = iti.getSelectedCountryData();
                if (countryData.iso2 === "in") {
                    validMsg.show();
                    $("#phone_country_code").val(countryData.dialCode);
                } else {
                    errorMsg.text("Only Indian (+91) numbers allowed.").show();
                }
            } else {
                errorMsg.text("Invalid number").show();
            }
        }
    });

    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
});
</script>