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
           data-bg-src="<?=base_url('public/assets/template/');?>assets/images/breadcumb/breadcumb-bg.png"
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
                    <a href="index.html"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Home</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Contact Us</li>
              </ul>
           </div>
        </div>
     </div>

    
     <section class="contact-section fix section-padding">
        <div class="container">
            <div class="contact-section-wrapper">
                <div class="row">
                  <div class="col-xl-5">
                    <div class="contact-info">
                      <div class="contact-info__contact">
                        <h5 class="contact-info__contact--title">Contact Information</h5>
                        <p class="contact-info__contact--subtitle">Say something to start a live chat!</p>
                        <div class="contact-info__contact--contact-items">
                          <ul class="contact-info-items">
                            <li>
                              <i class="fa-solid fa-phone"></i>
                              <a href="tel:<?=getappdata('phone') ?>"><?=getappdata('phone') ?></a>
                            </li>
    
                            <li>
                              <i class="fa-regular fa-envelope"></i>
                              <a href="mailto:<?=getappdata('email') ?>"><?=getappdata('email') ?></a>
                            </li>
                            <li>
                              <i class="fas fa-map-marker-alt"></i>
                              <a href=""><?=getappdata('address') ?> <?=getappdata('city') ?> <?=getappdata('state') ?> <?=getappdata('zip_code') ?> <?=getappdata('country') ?> </a>
                            </li>
    
                          </ul>
                        </div>
                        <div class="contact-info__contact--social-icon d-flex align-items-center">
                          <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                          <a href="https://x.com/"><i class="fab fa-twitter"></i></a>
                          <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                      </div>
                      <div class="contact-info__icon">
                        <div class="icon-1">
                          <img src="<?=base_url('public/assets/template/');?>assets/images/shape-1.png" alt="icon">
                        </div>
                        <div class="icon-2">
                          <img src="<?=base_url('public/assets/template/');?>assets/images/shape-2.png" alt="icon">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-7"> 
                        <div class="contact-form-items-1">
                        <form action="#" id="contact-form-1" method="POST">
                            <div class="row g-4">
                            <div class="col-xl-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="form-clt-1 mb-3">
                                    <label for="name">First Name</label>
                                <input type="text" name="name" id="name2" placeholder="I">
                                </div>
                            </div>
                            <div class="col-xl-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="form-clt-1 mb-3">  
                                    <label for="name">Last Name</label>
                                <input type="text" name="name" id="name" placeholder="Doe">
                                </div>
                            </div>
                            <div class="col-xl-6 wow fadeInUp mb-5" data-wow-delay=".5s">
                                <div class="form-clt-1">
                                    <label for="name">Email</label>
                                <input type="text" name="email" id="email212" placeholder="Email">
                                </div>
                            </div>
                            <div class=" col-xl-6 wow fadeInUp mb-5" data-wow-delay=".7s">
                                <div class="form-clt-1">
                                    <label for="name">Phone Number</label>
                                <input type="text" name="phone" id="phone" placeholder="Phone number">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="subjects">
                                    <h6>Select Subject?</h6>
                                    <div class="checkbox">
                                        <label class="checkbox-single">
                                            <span class="checkbox-area">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span> 
                                                <span class="text">General Inquiry</span> 
                                            </span> 
                                        </label>
                                        <label class="checkbox-single">
                                            <span class="checkbox-area">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span> 
                                                <span class="text">General Inquiry</span> 
                                            </span> 
                                        </label>
                                        <label class="checkbox-single">
                                            <span class="checkbox-area">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span> 
                                                <span class="text">General Inquiry</span> 
                                            </span> 
                                        </label>
                                        <label class="checkbox-single">
                                            <span class="checkbox-area">
                                                <input type="checkbox">
                                                <span class="checkmark d-center"></span> 
                                                <span class="text">General Inquiry</span> 
                                            </span> 
                                        </label>
                                    </div>
                                </div>
    
                            </div>
                            <div class="col-xl-12 wow fadeInUp" data-wow-delay=".3s">
                                <div class="form-clt-1">
                                    <label for="name">Message</label>
                                <textarea name="message" id="message" placeholder="Write your message.."></textarea>
                                </div>
                            </div>
                            <div class="btn-wrapper d-flex justify-content-end">
                                <a class="theme-btn style6" href="cart.html">Send Message</a>
    
                            </div>
                            </div>
                        </form>
                        </div>
                  </div> 
                </div>
              </div>
        </div>
      </section>
    



    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>