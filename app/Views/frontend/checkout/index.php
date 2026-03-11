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

                    
                    </div>
                    <!--  -->
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="" id="cartSubtotal"> </div>
                </div>
            </div>
        
        <!-- <h4 class="mb-4">Your Order</h4> -->
        
     
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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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