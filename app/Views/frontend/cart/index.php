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
                        placeholder="Search..."
                     />
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="breadcumb-section d-none d-sm-none d-md-block">
        <div
           class="breadcumb-container-wrapper"
           data-bg-src="<?=base_url('public/assets/template/');?>assets/images/breadcumb/cart.webp"
        >
           <div class="shape1">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_1.png"
                 alt="shape"
              />
           </div>
           <div class="shape2">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_2.png"
                 alt="shape"
              />
           </div>
           <div class="shape3">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_3.png"
                 alt="shape"
              />
           </div>
           <div class="shape4">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_4.png"
                 alt="shape"
              />
           </div>
           <div class="container">
              <ul class="breadcumb-wrapper">
                 <li>
                    <a href="<?=base_url();?>"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Products</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Cart</li>
              </ul>
           </div>
        </div>
     </div>

    
     <div class="cart-wrapper  section-padding fix bg-white">
        <div class="container">
            <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-12 col-12" id="cartItems">
                   
                   
                </div>
                <div class="col-sm-12 col-lg-4 col-md-4 " id="cartSubtotal">
                </div>
            </div>
     
        </div>
    </div>

<?= view('frontend/inc/footerLink') ?>
<script src="<?=base_url('public/assets/template/');?>assets/js/count.js"></script>

<script>
    mycart();

    function mycart(){
      
        $.ajax({
            url: "<?=base_url('cart/getMyCartItems');?>",
            method: "POST",
            success: function (response) {
                $('#cartItems').html(response.res);
                $('#cartSubtotal').html(response.subtotal);
            }
        });
    }


    function updateCart() {

      $.ajax({
         url: App.getSiteurl() + "cart/update",
         type: "POST",
         data: $("#cartForm").serialize(),

         beforeSend: function () {
               $(".plus-minus-input button").prop("disabled", true);
         },

         success: function (data) {

               if (data.status) {
                  cartNotification();
                  mycart();      // Reload cart
                  toastr.success(data.message); 
               } else {
                  toastr.error(data.message);
               }

         },

         complete: function () {
               $(".plus-minus-input button").prop("disabled", false);
         }

      });

   }


   function plusCartQty(btn){

    let input = $("#" + $(btn).data("field"));

    let qty = parseInt(input.val()) || 1;

    input.val(qty + 1);

    updateCart();

}


function minusCartQty(btn){

    let input = $("#" + $(btn).data("field"));

    let qty = parseInt(input.val()) || 1;

    if(qty > 1){

        input.val(qty - 1);

        updateCart();

    }

}



$(document).on("change", "input[name='quantity[]']", function(){

    let qty = parseInt($(this).val());

    if(qty < 1 || isNaN(qty)){
        $(this).val(1);
    }

    updateCart();

});



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
