<?= view('frontend/inc/header') ?>

      <div class="breadcumb-section">
        <div
           class="breadcumb-container-wrapper"
           data-bg-src="<?=base_url('public/assets/template/');?>assets/images/breadcumb/about_us_banner.webp"
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
                    <a href="<?=base_url()?>"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Home</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>About Us</li>
              </ul>
           </div>
        </div>
     </div>

    
           <section class="about-page-section pt-40 pb-40 fix">
         <div class="container">
             <div class="row gx-80 mt-20 d-flex align-items-center">
                 <div class="col-xl-8">
                     <div class="about-page-content" style="text-align:justify">
                         <h1>The RobinFood Promise</h1>
                         <p><b>Good food starts with trust.</b></p>
                         <p class="mb-15">
                           RobinFood is the health-focused brand from Arrikar Foods, the makers of Pavizham Rice. Our journey began in a small rice mill in Koovapady and has grown over the years with one simple belief: food should be wholesome, honest, and full of natural goodness.
                         </p>

                           <p class="mb-15">
                              We believe nutrition should never be lost along the way. That's why we work to preserve the goodness of rice bran and carefully craft every product to bring together nourishment, great taste, and uncompromising quality.
                           </p>
                           <p class="mb-15">
                              At RobinFood, every pack reflects the care, experience, and trust we've built over generations. Because healthy food isn't just about what you eat. It's about what you can trust to bring home.
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


    <section class="testimonial-section fix bg-color3 section-padding">
        <div class="container">

            <div class="row gy-4 gx-64 d-flex align-items-center">
              
                <div class="col-xl-12">
                    <div class="about-page-content testimonial-card-items-two row align-items-center">
                        <div class="col-sm-4">
                            <div class="about-page-thumb2 rounded-5 overflow-hidden">
                                <img src="<?=base_url('public/assets/template/');?>assets/img/director.webp" alt="thumb">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h1>Founder’s Message
                            </h1>
                            <h6>Mr. Robin George
                            </h6>
                            <p class="mb-15">Our journey began as a small rice mill in Koovapady, built on hard work, honesty, and a deep respect for food and people. Over the years, with the trust of our farmers, partners, and customers, we have grown into one of South India’s leading rice mills, supporting thousands of families along the way. RobinFood  was born from my belief that food should nourish, not just fill. Inspired by the spirit of sharing and care, we are committed to offering honest, healthy food that people can trust every day.
                            </p>
                        </div>
        
                    </div>
                </div>
            </div>
            </div>
            </section>

    

            <section class="about-page-section pt-40 pb-40 fix">
                <div class="container">
                  
                    <div class="row gy-4 gx-64 d-flex align-items-center">
                        <div class="col-xl-6">
                            <div class="about-page-content border p-3 rounded-4" style="background:#f5fff7;">
                                <h1>Our Vision
                                </h1>
                                <p class="mb-15">
                                    <?=getappdata('vision') ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="about-page-content border p-3 rounded-4" style="background:#f5fff7;">
                                <h1>Our Mission
                                </h1>
                                <p class="mb-15">  <?=getappdata('mission') ?></p>
                            </div>
                        </div>
                    </div>
        
        
        
        
                </div>
            </section>
<?= view('frontend/inc/footerLink') ?>
