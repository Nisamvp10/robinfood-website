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
                    <div class="about-page-content">
                        <!-- <h1>The RobinFood Promise </h1>
                        <p class="mb-15">
                            At RobinFood , we believe that good health begins with the food we eat every day. Our products are thoughtfully made to suit modern lifestyles while staying true to natural nutrition. By combining wholesome ingredients with advanced food processing methods, we create food that is both nourishing and enjoyable, making healthy eating simple and practical for every home.

                        </p>

                        <p class="mb-15">
                            With cutting-edge technology, expert supervision, and strict quality checks at every stage, we ensure that only the best reaches your table. Each RobinFood  product is carefully crafted to deliver great taste while keeping your health in balance. For us, food is not just about filling a plate; it’s about caring for the well-being of the people who trust us.

                        </p> -->

                        <h1>The RobinFood Promise</h1>
                         <p class="mb-15">RobinFood is a premium, health-focused brand from Arrikar Foods, the trusted makers of Pavizham Rice. Born from decades of expertise in rice milling, RobinFood was created with one clear purpose: to nourish people with food that is as honest as it is healthy.</p>

                             <p class="mb-15">Robin Foods began its journey as a small rice mill in Koovapady and, through a decade of hard work, has built a reputation for producing high-quality products that do not compromise on taste or nutrition.  Over the years, that commitment has helped us grow into one of South India’s leading rice mills, supporting thousands of families and earning the trust of generations. 
                           </p>
                           <p class="mb-15">
                              We aim to restore the forgotten goodness of rice bran, once a vital part of everyday diets. Through advanced technology, expert supervision, and strict quality assurance, we carefully preserve essential nutrients while creating products suited for today’s lifestyle.
                           </p>
                           <p>
                              Every RobinFood product is crafted with care, focusing on balanced nutrition, natural goodness, and great taste, because we believe healthy food should be easy to trust and enjoyable to eat. Inspired by the spirit of Robin Hood, RobinFood stands for goodness shared, food that supports better living, stronger families, and healthier communities.

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
