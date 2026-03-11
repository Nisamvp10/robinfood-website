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



      
    <!-- Login Section start  -->
    <section class="login-section fix section-padding">
        <div class="container">
            <div class="login-wrapper">
                <div class="row gx-5">
                    <div class="col-xl-6 offset-xl-0 col-md-5 m-auto offset-md-2">
                        <div class="contact-info-area">
                            <div class="contact-content">
                                <h2 class="contact-content__title">Forgot Password</h2>
                                <p class="contact-content__subtitle">Enter your email address to reset your password</p>
                                <form id="forgotPasswordForm" method="POST" class="contact-form-items">
                                    <div class="row g-4"> 
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <span>Email address*</span>
                                                <input type="text" name="username" id="username" placeholder="Enter your email">
                                                <div class="invalid-feedback" id="usernameError"></div>
                                            </div>
                                        </div>                                       
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" id="forgotPasswordBtn" class="theme-btn style6">
                                                Send Reset Code
                                            </button>
                                        </div>
                                    </div>
                                </form>

                              
                                <h5 class="contact-content__logtitle center">Don't Have an account? <a href="<?=base_url('register') ;?>">Sign Up</a> |</h5>
                             </div>
                       </div>
                    </div>
                    
                 
               </div>
            </div>
        </div>
     </section>


<?= view('frontend/inc/footerLink') ?>
<script src="<?=base_url('public/assets/template/');?>assets/js/auth.js"></script>
