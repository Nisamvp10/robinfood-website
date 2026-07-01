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

      <div class="breadcumb-section">
        <div
           class="breadcumb-container-wrapper"
           data-bg-src="<?= base_url('public/assets/template/') ?>assets/images/breadcumb/offer.webp"
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
                    <a href="<?=base_url('productlist');?>"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Products</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Offers</li>
              </ul>
           </div>
        </div>
     </div>

     <!--  -->
<div class="container">
    <div class="row justify-content-center mt-4 pb-5">
        <div class="col-lg-8">
         <?php 
         if(!empty($offers)) {
            foreach($offers as $offer) {
               ?>
                 <div class="coupon-card mb-2">

                     <div class="row align-items-center g-0 p-2">

                        <!-- Left -->
                        <div class="col-lg-3">
                              <div class="discount-box border rounded-2">
                                 <h2>
                                    <?= ($offer['discount_type'] == 1 ? 'Rs. '.number_format($offer['discount'],0) : number_format($offer['discount'],0).'%') ?>
                                 </h2>
                                 <span>OFF</span>
                              </div>
                        </div>

                        <!-- Middle -->
                        <div class="col-lg-6">
                              <div class="coupon-content mx-md-3">

                                 <h5 class="coupon-title">
                                    <?= $offer['title'] ?? 'Special Discount Offer'; ?>
                                 </h5>

                                 <p class="coupon-description">
                                    <?= $offer['description']; ?>
                                 </p>

                                 <div class="coupon-meta">

                                    <span class="coupon-code">
                                          <i class="fa fa-ticket"></i>
                                          <?= $offer['coupencode']; ?>
                                    </span>

                                    <span class="expire">
                                          <i class="fa fa-clock-o"></i>
                                          Valid Till :
                                          <?= date('d M Y', strtotime($offer['validity_to'])) ?>
                                    </span>

                                 </div>

                              </div>
                        </div>

                        <!-- Right -->
                        <div class="col-lg-3">

                              <div class="coupon-action text-center">

                                 <button
                                    class="coupon-btn"
                                    onclick="copyCode('<?= $offer['coupencode']; ?>')">

                                    GET CODE

                                 </button>

                              </div>

                        </div>

                     </div>

                  </div>

               <?php
            }
            
         } ?>

       

        </div>
    </div>
</div>

<?= view('frontend/inc/footerLink') ?>
<script>
function copyCode(code) {
   navigator.clipboard.writeText(code);
   toastr.success('Code copied to clipboard');
}
</script>