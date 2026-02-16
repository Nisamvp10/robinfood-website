
<?= view('frontend/inc/headerLink');?>
<body>
      <!-- Preloader Start -->
      <div id="preloader" class="preloader">
         <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
               <span data-text-preloader="R" class="letters-loading"> R </span>
               <span data-text-preloader="O" class="letters-loading"> O </span>
               <span data-text-preloader="B" class="letters-loading"> B </span>
               <span data-text-preloader="I" class="letters-loading"> I </span>
               <span data-text-preloader="N" class="letters-loading"> N </span>
               <span data-text-preloader="F" class="letters-loading"> F </span>
               <span data-text-preloader="O" class="letters-loading"> O </span>
               <span data-text-preloader="O" class="letters-loading"> O </span>
               <span data-text-preloader="D" class="letters-loading"> D </span>

            </div>
            <p class="text-center">Loading</p>
         </div>
         <div class="loader">
            <div class="row">
               <div class="col-3 loader-section section-left">
                  <div class="bg"></div>
               </div>
               <div class="col-3 loader-section section-left">
                  <div class="bg"></div>
               </div>
               <div class="col-3 loader-section section-right">
                  <div class="bg"></div>
               </div>
               <div class="col-3 loader-section section-right">
                  <div class="bg"></div>
               </div>
            </div>
         </div>
      </div>

      <!-- Back To Top Start -->
      <button id="back-top" class="back-to-top">
         <i class="fa-solid fa-chevron-up"></i>
      </button>

      <!-- Offcanvas Area Start -->
      <div class="fix-area">
         <div class="offcanvas__info">
            <div class="offcanvas__wrapper">
               <div class="offcanvas__content">
                  <div
                     class="offcanvas__top mb-5 d-flex justify-content-between align-items-center"
                  >
                     <div class="offcanvas__logo">
                        <a href="index.html">
                           <img
                              src="<?=base_url('public/assets/template/');?>assets/images/logo.png"
                              alt="logo-img"
                           />
                        </a>
                     </div>
                     <div class="offcanvas__close">
                        <button>
                           <i class="fas fa-times"></i>
                        </button>
                     </div>
                  </div>
                  <p class="text d-none d-xl-block">
                     Backed by Arrikar Foods and Pavizham Rice, Robin Hood stands for uncompromising quality and nutrition. Expert supervision and strict quality checks ensure the food you can trust every day.
                  </p>
                  <div class="mobile-menu fix mb-3"></div>
                  <div class="header-cataegory-item">
                     <ul class="header-cataegory">
                        <li>
                           <a href="#">
                              <span class="left-icon"
                                 ><i class="icon-app"></i
                              ></span>
                              all categories
                              <span class="right-icon"
                                 ><i class="fa-regular fa-chevron-down"></i
                              ></span>
                           </a>
                        </li>
                     </ul>
                     <ul class="sub-cataegory">
                            
                             <?php
                            if(!empty(services())) {
                                foreach(services() as $itemCategory) {
                                    ?>
                                    <li>
                                        <a href="<?= base_url('productlist?category='.$itemCategory['slug']) ?>"><?= $itemCategory['category'] ?></a>
                                    </li>
                                    <?php
                                }
                            }
                             ?>
                           </ul>
                  </div>
                  <div class="offcanvas__contact">
                     <h4>Contact Info</h4>
                     <ul>
                        <li class="d-flex align-items-center">
                           <div class="offcanvas__contact-icon">
                              <i class="fal fa-map-marker-alt"></i>
                           </div>
                           <div class="offcanvas__contact-text">
                              <a target="_blank" href="#"
                                 >Nambiyattukudy Food Spices
                                 Near Aimuri Ganapathi Temple.
                                 Koovappady P.O Perumbavoor
                                 Ernakulam, Kerala</a
                              >
                           </div>
                        </li>
                        <li class="d-flex align-items-center">
                           <div class="offcanvas__contact-icon mr-15">
                              <i class="fal fa-envelope"></i>
                           </div>
                           <div class="offcanvas__contact-text">
                              <a href="#"
                                 ><span class="#"
                                    >info@robinfood.com</span
                                 ></a
                              >
                           </div>
                        </li>
                        <li class="d-flex align-items-center">
                           <div class="offcanvas__contact-icon mr-15">
                              <i class="fal fa-clock"></i>
                           </div>
                           <div class="offcanvas__contact-text">
                              <a target="_blank" href="#"
                                 >Mod-friday, 09am -05pm</a
                              >
                           </div>
                        </li>
                        <li class="d-flex align-items-center">
                           <div class="offcanvas__contact-icon mr-15">
                              <i class="far fa-phone"></i>
                           </div>
                           <div class="offcanvas__contact-text">
                              <a href="#">+91 7034741741 
                              </a>
                           </div>
                        </li>
                     </ul>
                     <div class="header-button mt-4">
                        <a href="contact.html" class="theme-btn text-center">
                           <span
                              >Get A Quote<i
                                 class="fa-solid fa-arrow-right-long"
                              ></i
                           ></span>
                        </a>
                     </div>
                     <div class="social-icon d-flex align-items-center">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="offcanvas__overlay"></div>

      <!-- Header Section Start -->
      <header class="header-section-1">
         <div id="header-sticky" class="header-1">
            <div class="header-top-one">
               <div class="phone-icon">
                  <i class="icon-telephone"></i>
                  <a href="#">+91 7034741741</a>
               </div>
               <div class="offer">
                  <div class="subtitle style1">
                     <i class="icon-tag"></i>
                     15% <span class="color-text"> discount </span> for all
                     items
                  </div>
               </div>
               <div class="lang">
               

                  <div class="user">
                     <a href="#">
                        <i class="fa-solid fa-user"></i>
                        My account
                     </a>
                  </div>
               </div>
            </div>

            <div class="container-fluid">
               <div class="mega-menu-wrapper">
                  <div class="header-main">
                     <div class="header-left">
                        <div class="logo">
                           <a href="<?= base_url() ?>" class="header-logo">
                              <img
                                 src="<?=base_url('public/assets/template/');?>assets/images/logo.png"
                                 alt="logo-img"
                              />
                           </a>
                        </div>
                        <div class="header-cataegory-item">
                           <ul class="header-cataegory">
                              <li>
                                 <a href="#">
                                    <span class="left-icon"
                                       ><i class="icon-app"></i
                                    ></span>
                                    all categories
                                    <span class="right-icon"
                                       ><i
                                          class="fa-regular fa-chevron-down"
                                       ></i
                                    ></span>
                                 </a>
                              </li>
                           </ul>
                           <ul class="sub-cataegory">
                            <?php
                            if(!empty(services())) {
                                foreach(services() as $itemCategory) {
                                    ?>
                                    <li>
                                        <a href="<?= base_url('productlist?category='.$itemCategory['slug']) ?>"><?= $itemCategory['category'] ?></a>
                                    </li>
                                    <?php
                                }
                            }
                             ?>
                           </ul>
                        </div>
                     </div>
                     <div
                        class="header-right d-flex justify-content-end align-items-center">
                        <div class="mean__menu-wrapper">
                           <div class="main-menu">
                              <nav id="mobile-menu">
                                 <ul>
                                    
                                    <li class="active ">
                                       <a href="<?= base_url('index') ?>"> Home</a>
                                    </li>
                                    <li class="active ">
                                       <a href="<?= base_url('about-us') ?>"> About Us</a>
                                    </li>
 
                                    <li class="active has-dropdown">
                                       <a href="<?= base_url('productlist') ?>"> Products <i class="fa-regular fa-plus"></i></a>
                                       <ul class="submenu">
                                          <?php
                                           if(!empty(services())) {
                                                foreach(services() as $itemCategory) {
                                                      ?>
                                                      <li class="active ">
                                                         <a href="<?= base_url('productlist?category='.$itemCategory['slug']) ?>"><?= $itemCategory['category'] ?></a>
                                                      </li>
                                                      <?php
                                                }
                                             }
                                             ?>
                                       </ul>
                                    </li>

                                    <li class="active ">
                                       <a href="<?= base_url('offers') ?>">Offers</a>
                                    </li>
                                    <li class="active ">
                                       <a href="<?= base_url('gallery') ?>">Gallery</a>
                                    </li>
                                    <li>
                                       <a href="<?= base_url('contact') ?>">Contact Us</a>
                                    </li>
                                 </ul>
                              </nav>
                           </div>
                        </div>
                        <a href="#" class="search-trigger search-icon"
                           ><i class="fal fa-search"></i
                        ></a>
                        <div class="menu-cart" id="menuCart"></div>
                        
                        <a class="wishlist" href="cart.html"
                           ><i class="fa-regular fa-heart"></i
                        ></a>
                        <div
                           class="header__hamburger d-block d-xl-none my-auto"
                        >
                           <div class="sidebar__toggle">
                              <i class="fas fa-bars"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>

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

   