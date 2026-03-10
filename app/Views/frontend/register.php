<?= view('frontend/inc/header') ?>
   <!-- Breadcumb Section Start -->
      <div class="breadcumb-section">
         <div
            class="breadcumb-container-wrapper"
            data-bg-src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-bg.png"
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
                     <a href="<?=base_url() ;?>"
                        ><i class="fa-sharp fa-light fa-house"></i
                     ></a>
                  </li>
                  <li><i class="fa-solid fa-chevron-right"></i></li>
                  <li>Home</li>
                  <li><i class="fa-solid fa-chevron-right"></i></li>
                  <li>Login</li>
               </ul>
            </div>
         </div>
      </div>



    <!-- Register Section start  -->
     <section class="register-section fix section-padding">
        <div class="container">
            <div class="register-wrapper">
                <div class="row gx-5">
                    <div class="col-xl-6 offset-xl-0 col-md-8 offset-md-2">
                        <div class="contact-info-area">
                            <div class="contact-content">
                                <h2 class="contact-content__title">Get Started Now</h2>
                                <p class="contact-content__subtitle">Enter your Credentials to access your account</p>
                                <form  id="registerForm" method="POST" class="contact-form-items">
                                    <div class="row g-4">
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <span>Your name*</span>
                                                <input type="text" name="name" id="name" placeholder="Enter your name">
                                                <div class="invalid-feedback" id="nameError"></div>
                                            </div>
                                        </div>
                                           <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <span>Phone*</span>
                                                <input type="text" name="phone" id="phone" placeholder="Enter your phone Number name">
                                                <div class="invalid-feedback" id="phoneError"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <span>Email address*</span>
                                                <input type="text" name="email" id="email" placeholder="Enter your email">
                                                <div class="invalid-feedback" id="emailError"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".7s">
                                            <div class="form-clt">
                                                <span>Password*</span>
                                                <input type="text" name="password" id="password" placeholder="********">
                                                <div class="invalid-feedback" id="passwordError"></div>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <div class="">
                                              <input id="reviewcheck" name="reviewcheck" type="checkbox">
                                                <label class="form-check-label" for="reviewcheck">
                                                    I agree to the <span>terms & policy</span>
                                                </label>
                                                <div class="invalid-feedback" id="reviewcheckError"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" class="theme-btn style6">
                                                Sign Up
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="or-border">
                                    <div class="border"></div>
                                    <p>Or</p>
                                </div>

                               
                                <h5 class="contact-content__logtitle center">Have an account? <a href="<?=base_url('login')?>">Sign Up</a></h5>
                             </div>
                       </div>
                    </div>
                   <div class="col-xl-6 offset-xl-0 col-md-8 offset-md-2">
                    <div class="register-thumb">
                        <img src="<?=base_url('public/assets/template/');?>assets/img/register/loginThumb.jpg" alt="register-thumb">
                    </div>
                 </div>
               </div>
            </div>
        </div>
     </section>




<?= view('frontend/inc/footerLink') ?>
<script src="<?=base_url('public/assets/template/');?>assets/js/auth.js"></script>
