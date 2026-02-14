<?= view('frontend/inc/header') ?>

<div class="breadcumb-section">
   <div
      class="breadcumb-container-wrapper"
      data-bg-src="assets/images/breadcumb/breadcumb-bg.png">
      <div class="shape1">
         <img
            src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_1.png"
            alt="shape" />
      </div>
      <div class="shape2">
         <img
            src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_2.png"
            alt="shape" />
      </div>
      <div class="shape3">
         <img
            src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_3.png"
            alt="shape" />
      </div>
      <div class="shape4">
         <img
            src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_4.png"
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
            <li>Products Listing</li>
         </ul>
      </div>
   </div>
</div>

<section class="shop-section section-padding2 fix">
   <div class="container">
      <div class="row gx-30 gy-30">
         <div class="col-lg-12">

            <!-- PRODUCTS -->
            <div class="row g-4">

            <?php if (!empty($products)) :
                foreach ($products as $product) :

                    $price = calculatePrice(
                        $product['price'],
                        $product['compare_price'],
                        $product['price_offer_type']
                    );

                    $offerPrice  = $price['offer_price'];
                    $discount    = $price['discount'];
                    $actualPrice = $price['actual_price'];
            ?>

                <div class="col-xl-3 col-md-6">
                  <div class="featured-product-item-one">
                     <div class="featured-product-item-one__thumb">
                        <img src="<?=validImg($product['product_image'])?>" alt="thumb" />
                        <?php
                            if(!empty($product['compare_price'])) {
                               if($product['price_offer_type'] ==1 && $product['compare_price'] > 0){
                                  $type = ' OFF';
                               }else{
                                  $type = '% OFF';
                               }
                               ?>
                               <div class="badge"><?= $discount ?><?= $type ?></div>
                               <?php
                            } ?>
                        <div class="icon">
                           <button
                              data-bs-toggle="modal"
                              data-bs-target="#exampleModal2">
                              <i class="fa-regular fa-eye"></i>
                           </button>
                           <a href="#"><i class="fa-regular fa-heart"></i></a>
                           <a href="javascript:void(0);" class="add-to-cart" data-id="<?= $product['id'] ?>">
                              <i class="fa-light fa-bag-shopping"></i>
                           </a>
                        </div>
                     </div>
                     <div
                        class="featured-product-item-one__content">
                        <div
                           class="featured-product-item-one__content--details-wrapper">
                           <div class="price">
                              <h6>
                                 <a href="<?=base_url('product-details/'.$product['slug'])?>"><?= $product['product_title'] ?></a>
                              </h6>
                              <div class="star-wrapper">
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <i class="fa-solid fa-star"></i>
                                 <span>0 Review</span>
                              </div>
                              <span class="price"><?= money_format_custom($offerPrice) ?>
                              <?php     if($product['compare_price'] > 0){?>
                                 <small><?=money_format_custom($actualPrice) ?></small></span>
                                 <?php } ?>
                           </div>
                           
                        </div>
                     </div>
                  </div>
               </div>

            <?php endforeach; else: ?>
                <p class="text-center">No products found</p>
            <?php endif; ?>

            </div>

            <!-- PAGINATION -->
            <div class="pagination justify-content-center mt-10 pt-0">
                <?= $pager->links('default', 'custom_pagination') ?>


            </div>

         </div>
      </div>
   </div>
</section>



<?= view('frontend/inc/footerLink') ?>