<?= view('frontend/inc/header') ?>

      <!-- Intro Section S T A R T -->
      <section class="intro-section">
         <div class="intro-container-wrapper style1">
            <div class="container">
               <div class="intro-wrapper style1">
                 
                  <div class="thumb-shape-wrapper">
                      <?php
                        if(!empty($banner)) {
                           $t = 1;
                           foreach($banner as $imgThumb) {
                           ?>
                           <div class="thumbShape thumbShape<?= $t ?>">
                              <img src="<?= validImg($imgThumb->image) ?>" alt="shape" />
                           </div>
                           <?php
                          $t++;  }
                        }?>
                   
                   
                  </div>

                  <div class="row gy-5 d-flex align-items-center">
                     <div class="col-xl-6">
                        <div class="intro-content">
                           <div class="subtitle style1">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                 <g clip-path="url(#clip0_86_101)">
                                    <path d="M12.8333 6.10352e-05H7.98425C7.66347 6.10352e-05 7.21514 0.185895 6.9885 0.412368L0.34046 7.06037C-0.113477 7.51379 -0.113477 8.2572 0.34046 8.71008L5.29046 13.6599C5.74338 14.1133 6.48606 14.1133 6.93966 13.6594L13.5877 7.01242C13.8141 6.78598 14 6.33693 14 6.01684V1.16678C14 0.525228 13.4748 6.10352e-05 12.8333 6.10352e-05ZM10.4998 4.66675C9.85547 4.66675 9.33311 4.14384 9.33311 3.50004C9.33311 2.85517 9.85547 2.33332 10.4998 2.33332C11.1442 2.33332 11.6667 2.85517 11.6667 3.50004C11.6667 4.14384 11.1442 4.66675 10.4998 4.66675Z" fill="#0A111E" />
                                 </g>
                                 <defs>
                                    <clipPath id="clip0_86_101"> <rect width="14" height="14" fill="white" /></clipPath>
                                 </defs>
                              </svg>
                             
                                    
                              59% <span class="color-text"> discount </span> for
                              all items
                           </div>
                           <h1>  health-oriented brand from Arrikar Foods</h1>
                           <p>
                              At RobinFood, we focus on red bran rice because we believe real wellness begins with
                              simple choices:
                           </p>
                        

                           <div class="btn-wrapper">
                              <a class="theme-btn style6" href="<?=base_url('productlist');?>">Products</a>
                           </div>

                        </div>
                     </div>
                     <div class="col-xl-6">
                        <div class="thumb-slider">
                           <div class="introThumbShape">
                              <img
                                 src="<?=base_url('public/assets/template/');?>assets/images/introThumbShape1_4.png"
                                 alt="shape"
                              />
                           </div>
                           <div class="intro-thumb">
                              <div
                                 class="swiper gt-slider"
                                 id="introSliderOne"
                                 data-slider-options='{"loop": true, "autoplay": true, "effect": "fade", "breakpoints": {"0": {"slidesPerView": 1}}}'
                              >
                                 <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                       <div class="thumb">
                                          <img
                                             src="<?=base_url('public/assets/template/');?>assets/images/thumb1.png"
                                             alt="thumb"
                                          />
                                       </div>
                                    </div>
                                    <div class="swiper-slide">
                                       <div class="thumb">
                                          <img
                                             src="<?=base_url('public/assets/template/');?>assets/images/thumb2.png"
                                             alt="thumb"
                                          />
                                       </div>
                                    </div>
                                    <div class="swiper-slide">
                                       <div class="thumb">
                                          <img
                                             src="<?=base_url('public/assets/template/');?>assets/images/thumb3.png"
                                             alt="thumb"
                                          />
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Add Pagination -->
                                 <div class="slider-pagination"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </section>

      <!-- Marquee Section S T A R T -->
      <div class="marquee-section1 pt-20">
         <div class="container">
            <div class="mycustom-marque">
               <div class="scrolling-wrap">
                  <div class="comm">
                      <?php
                        if(!empty($tagline)) {
                           $t = 1;
                           foreach($tagline as $scroll) {
                           ?>
                            <div style="width:30px">
                                <img src="<?= validImg($scroll->image)?>" alt="img"/>
                            </div>
                           <div class="cmn-textslide"><?= esc($scroll->title) ?></div>
                        <?php
                           }
                        }
                        ?>
                  </div>
                  <div class="comm">
                     <div>
                        <img
                           src="<?=base_url('public/assets/template/');?>assets/images/starIcon1_1.svg"
                           alt="img"
                        />
                     </div>
                     <div class="cmn-textslide">Gentle on Digestion</div>
                    
                     
                  </div>
               </div>
            </div>
         </div>
      </div>


      <section class="about-page-section pt-40 pb-40 fix">
         <div class="container">
             <div class="row gx-80 mt-20 d-flex align-items-center">
                 <div class="col-xl-8">
                     <div class="about-page-content">
                         <h1>About Robinfood </h1>
                         <p class="mb-15">Robinfood is a premium, health-focused brand from Arrikar Foods, the trusted makers of Pavizham Rice. Born from decades of expertise in rice milling, Robinfood was created with one clear purpose: to nourish people with food that is as honest as it is healthy.</p>

                           <p>Robin Foods began its journey as a small rice mill in Koovapady and, through a decade of hard work, has built a reputation for producing high-quality products that do not compromise on taste or nutrition.  Over the years, that commitment has helped us grow into one of South India’s leading rice mills, supporting thousands of families and earning the trust of generations. 
                           </p>
                           <p>
                              We aim to restore the forgotten goodness of rice bran, once a vital part of everyday diets. Through advanced technology, expert supervision, and strict quality assurance, we carefully preserve essential nutrients while creating products suited for today’s lifestyle.
                           </p>
                           <p>
                              Every Robinfood product is crafted with care, focusing on balanced nutrition, natural goodness, and great taste, because we believe healthy food should be easy to trust and enjoyable to eat. Inspired by the spirit of Robin Hood, Robinfood stands for goodness shared, food that supports better living, stronger families, and healthier communities.

                           </p>
                     </div>
                 </div>
                 <div class="col-xl-4">
                     <div class="about-page-thumb2">
                         <img src="<?=base_url('public/assets/template/');?>assets/images/abt.jpg" alt="thumb">
                     </div>
                 </div>
             </div>
         </div>
     </section>
 

      <section class="feature-section section-padding fix">
         <div class="container">
             <div class="row gy-5">
                 <div class="col-xl-3 col-md-6">
                     <div class="feature-box-item-two">
                         <div class="feature-box-item-two__icon">
                             <img src="<?=base_url('public/assets/template/');?>assets/images/featureIcon2_1.png" alt="icon">
                         </div>
                         <div class="feature-box-item-two__content">
                             <h6>Shop Online</h6>
                             <p class="feature-box-item-two__content--text">Order your groceries online</p>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-6">
                     <div class="feature-box-item-two">
                         <div class="feature-box-item-two__icon">
                             <img src="<?=base_url('public/assets/template/');?>assets/images/featureIcon2_2.png" alt="icon">
                         </div>
                         <div class="feature-box-item-two__content">
                             <h6>Choose Shipment</h6>
                             <p class="feature-box-item-two__content--text">Home Delivery/Neighbourhood Pickup

                             </p>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-6">
                     <div class="feature-box-item-two">
                         <div class="feature-box-item-two__icon">
                             <img src="<?=base_url('public/assets/template/');?>assets/images/featureIcon2_3.png" alt="icon">
                         </div>
                         <div class="feature-box-item-two__content">
                             <h6>Choose Payment</h6>
                             <p class="feature-box-item-two__content--text">COD or Online

                             </p>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-3 col-md-6">
                     <div class="feature-box-item-two">
                         <div class="feature-box-item-two__icon">
                             <img src="<?=base_url('public/assets/template/');?>assets/images/featureIcon2_4.png" alt="icon">
                         </div>
                         <div class="feature-box-item-two__content">
                             <h6>Get your Supplies
                           </h6>
                             <p class="feature-box-item-two__content--text">Home Delivered/Pick-it-Up Yourself

                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 

         <!-- Best Seller Section S T A R T -->
         <section class="best-seller-section section-padding fix bg-1">
            <div class="container">
               <div class="section-top-wrapper">
                  <div class="row gy-3">
                     <div class="col-lg-3">
                        <div class="section-title">
                           <div class="subtitle style1">Premium Products</div>
                           <h2 class="title">Premium Products</h2>
                        </div>
                     </div>
                     <div class="col-lg-9 d-flex justify-content-xl-end">
                        <div class="best-seller-tab-btn-wrapper">
                           <ul class="nav nav-pills" id="pills-tab" role="tablist">
                             
                          
                              <li class="nav-item" role="presentation">
                                 <a class="theme-btn style7" href="#!">View all</a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="tab-content" id="pills-tabContent">
                        <div
                           class="tab-pane fade show active"
                           id="pills-home"
                           role="tabpanel"
                           aria-labelledby="pills-home-tab"
                           tabindex="0">
                           <div class="best-seller-tab-content-wrapper">
                              <div class="row g-4">
                                <?php
                                if(!empty($premiumProducts)) {
                                    foreach($premiumProducts as $premiumproduct) {
                                        $price = calculatePrice($premiumproduct->price,$premiumproduct->compare_price,$premiumproduct->price_offer_type);
                                        $offerPrice = $price['offer_price'];
                                        $discount = $price['discount'];
                                        $actualPrice = $price['actual_price'];

                                        
                                ?>
                                 <div class="col-xl-4 col-md-6">
                                    <div class="best-seller-one">
                                       <div class="best-seller-one__thumb">
                                          <img src="<?=validImg($premiumproduct->product_image)?>" alt="thumb" width="100%" />
                                       </div>
                                       <div class="best-seller-one__content">
                                          <h4 class="best-seller-one__content-title">
                                             <a href="productdetials.html" ><?=$premiumproduct->product_title?></a>
                                          </h4>
                                          <div class="best-seller-one__star-wrap">
                                             <div class="star">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                             </div>
                                             <span>0 Review</span>
                                          </div>
                                          <h4 class="best-seller-one__content-price">
                                             <span class="offer-price"><?=money_format_custom($offerPrice)?></span>
                                             <?php
                                              if($premiumproduct->compare_price > 0){?>
                                             <span class="original-price"><?=money_format_custom($actualPrice)?></span>
                                             <?php } ?>
                                             
                                          </h4>
                                          <div class="best-seller-one__icons">
                                             <a href="#"><i class="fa-light fa-heart"></i></a>
                                             <a href="#"><i class="fa-light fa-bag-shopping"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <?php
                                    }
                                }
                                ?>
                               
                              </div>
                           </div>
                        </div>
                      
                     </div>
                  </div>
               </div>
               
               <div
               class="video-container bg-img" style="background-image: url(<?=base_url('public/assets/template/');?>assets/images/video-bg.jpg)">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <div class="video-content">
                        <div class="video-box">
                           <a href="#" class="play-btn popup-video" >
                              <i class="fa-sharp fa-solid fa-play"></i>
                           </a>
                        </div>
                        <div class="section-title">
                           <h3 class="title">See The Worlds Like Birds</h3>
                        </div>
                        <a class="theme-btn style3" href="<?=base_url('productlist');?>">
                           View All Products</a>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="video-thumb">
                        <img src="<?=base_url('public/assets/template/');?>assets/images/mm.png" alt="Thumb" />
                     </div>
                  </div>
               </div>
            </div>

            </div>
         </section>


          <!-- Featured product Section S T A R T -->
      <section class="featured-product-section section-padding fix">
         <div class="container">
            <div class="featured-product-wrapper style1">
               <div class="top-deals-wrapper style1 text-center mb-30">
                  <div class="section-title">
                     <div class="subtitle style1">featured products</div>
                     <h2 class="title">Our featured products</h2>
                  </div>
               </div>
               <div class="feature-flex-tab-wrapper">
                  <div class="feature-tab-btn-wrapper">
                    <ul class="nav nav-pills justify-content-center mb-4" id="categoryTabs">

    <li class="nav-item">
        <button class="nav-link active" data-category="all">
            All
        </button>
    </li>

    <?php if (!empty($itemCategories)) {
        foreach ($itemCategories as $cat) { ?>
            <li class="nav-item">
                <button class="nav-link" data-category="<?= $cat->id ?>">
                    <?= $cat->category ?>
                </button>
            </li>
    <?php } } ?>

</ul>

                  </div>
                  <div class="feature-select d-none"> 
                     <div class="nav-item">
                        <div class="form">
                           <select class="single-select w-100">
                              <option>Select categories</option>
                              <option>Rice</option>
                              <option>Millet</option>
                              <option>Others</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  
               </div>

               <div class="tab-content" id="pills-tabContent2">
                  <div
                     class="tab-pane fade show active"
                     id="pills-one"
                     role="tabpanel"
                     aria-labelledby="pills-one-tab"
                  >
                     <div class="feature-tab-content">
                        <div class="row g-4">
                           <?php if (!empty($featuredProducts)) {
                     foreach ($featuredProducts as $featuredProduct) {

                        $price = calculatePrice(
                              $featuredProduct->price,
                              $featuredProduct->compare_price,
                              $featuredProduct->price_offer_type
                        );

                        $offerPrice  = $price['offer_price'];
                        $discount    = $price['discount'];
                        $actualPrice = $price['actual_price'];
                  ?>

                  <div class="col-xl-4 col-md-6 product-item" data-category="<?= $featuredProduct->category_id ?>">
                     <div class="featured-product-item-one">
                        <div class="featured-product-item-one__thumb">
                           <img
                              src="<?=validImg($featuredProduct->product_image)?>"
                              alt="thumb"
                           />
                                 <?php
                                 if(!empty($featuredProduct->compare_price)) {
                                    if($featuredProduct->price_offer_type ==1 && $featuredProduct->compare_price > 0){
                                       $type = ' OFF';
                                    }else{
                                       $type = '% OFF';
                                    }
                                    ?>
                                    <div class="badge"><?= $discount ?><?= $type ?></div>
                                    <?php
                                 } ?>
                                    <div class="icon">
                                       <a
                                          href="<?=base_url('productdetials/'.$featuredProduct->slug)?>"
                                       >
                                          <i class="fa-regular fa-eye"></i>
                                    </a>
                                       <a href="#"
                                          ><i class="fa-regular fa-heart"></i
                                       ></a>
                                       <a href="#">
                                          <i
                                             class="fa-light fa-bag-shopping"
                                          ></i>
                                       </a>
                                    </div>
                                 </div>
                                 <div
                                    class="featured-product-item-one__content"
                                 >
                                    <div
                                       class="featured-product-item-one__content--details-wrapper"
                                    >
                                       <div class="price">
                                          <h6>
                                             <a href="<?=base_url('productdetials/'.$featuredProduct->slug)?>"><?= $featuredProduct->product_title ?></a>
                                          </h6>
                                          <div class="star-wrapper">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <span>0 Review</span>
                                          </div>
                                          <span class="price">
                                             <?=money_format_custom($offerPrice)?>
                                             <?php
                                              if($featuredProduct->compare_price > 0){?>
                                             <small><?=money_format_custom($actualPrice)?></small>
                                             <?php } ?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            </div>

                           <?php } } ?>
                     
                        </div>
                     </div>
                  </div>
             
                 
               </div>
            </div>
         </div>
      </section>


      <section class="promo-section section-padding fix pt-0">
         <div class="container">
            <div class="promo-wrapper style1">
               <div class="row">
                  <div class="col-lg-5">
                     <div class="promo-card promo-card_1">
                        <div class="thumb">
                           <img
                              src="<?=base_url('public/assets/template/');?>assets/images/thumb1.png"
                              alt="Thumb"
                           />
                        </div>
                        <div class="promo-content">
                           <div class="promo-info">
                              <p class="offer-text">GET 30% OFF</p>
                              <h3 class="promo-title"> Red Bran Rice</h3>
                           </div>
                           <div class="promo-btn-wrapper">
                              <a
                                 class="theme-btn style5"
                                 href="<?=base_url('productlist');?>"
                              >
                                 View All</a
                              >
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-7">
                     <div class="promo-card promo-card_2">
                        <div class="thumb">
                           <img
                              src="<?=base_url('public/assets/template/');?>assets/images/thumb4.png"
                              alt="Thumb"
                           />
                        </div>
                        <div class="promo-content">
                           <div class="promo-info">
                              <p class="offer-text">LIMITED OFFER</p>
                              <h3 class="promo-title">
                                 Don't Miss 25% Off On All Item
                              </h3>
                           </div>
                           <div class="promo-btn-wrapper">
                              <a
                                 class="theme-btn style5"
                                 href="<?=base_url('productlist');?>"
                              >
                                 View All</a
                              >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>


   



      <section class="testimonial-section fix section-padding margin-bottom-40">
         <div class="container">
            <div class="section-title">
               <div class="subtitle style1">Testimonial</div>
               <h2 class="title">What our client say</h2>
            </div>
            <div class="swiper testimonial-slider-one">
               <div
                  class="swiper gt-slider"
                  id="testimonialSliderOne"
                  data-slider-options='{"loop": true,"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":1,"centeredSlides":true},"768":{"slidesPerView":1},"992":{"slidesPerView":2},"1200":{"slidesPerView":3}}}'
               >
                  <div class="swiper-wrapper">
                     <?php
                     if(!empty($feedback)) {
                        foreach($feedback as $feedback) {
                     ?>
                     <div class="swiper-slide">
                        <div class="testimonial-card-items-one">
                           <p>
                              <?= $feedback->note ?>
                           </p>
                           <div
                              class="client-info-wrapper d-flex align-items-center justify-content-between"
                           >
                              <div class="client-info">
                                 <div
                                    class="client-img bg-cover"
                                    style="
                                       background-image: url(<?=validImg($feedback->profile)?>);
                                    "
                                 >
                                   
                                 </div>
                                 <div class="content">
                                    <h3><?= $feedback->username ?></h3>
                                    <span><?= $feedback->designation ?>
                                    </span>
                                    <div class="star">
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-regular fa-star"></i>
                                       <i class="fa-regular fa-star"></i>
                                    </div>
                                 </div>
                              </div>
                              <!-- <div class="logo">
                                        <img src="assets/img/testimonial/logo1.png" alt="">
                                    </div> -->
                           </div>
                        </div>
                     </div>
                     <?php
                        }
                     }   
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </section>


 <?= view('frontend/inc/footerLink') ?>
<script>
document.querySelectorAll('#categoryTabs button').forEach(button => {

    button.addEventListener('click', function () {

        // active button style
        document.querySelectorAll('#categoryTabs button')
            .forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        const selectedCategory = this.dataset.category;

        document.querySelectorAll('.product-item').forEach(item => {

            if (
                selectedCategory === 'all' ||
                item.dataset.category === selectedCategory
            ) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }

        });
    });

});
</script>
