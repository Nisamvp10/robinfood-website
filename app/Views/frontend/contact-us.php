<?= view('frontend/inc/header') ?>

	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque">
                       
                            Contact us
                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">
                                 
                                    Contact us</li>
                     

							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>





    <!-- Page Contact Us Start -->
    <div class="page-contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Contact Us Content Start -->
                    <div class="contact-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Get in Touch – We're Here to Help!
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                                Dr. Ram Sudhan Subramaniyan is a highly respected expert in joint replacement, sports injuries, and musculoskeletal care. Specializing in knee, hip, and shoulder replacement improve their quality of life.


                            </p>
                        </div>
                        <!-- Section Title End -->
                    </div>
                    <!-- Contact Us Content End -->
                </div>

                <div class="col-lg-8">
                    <!-- Contact Info List Start -->
                    <div class="contact-info-list">
                        <!-- Contact Info Item Start -->
                        <div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <img src="<?= base_url('public/assets/template/images/icon-location.svg')?>" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>location</h3>
                                <p>
                                    9/38, Pulinchode, PO, Potta - Moonupeedika Rd, near pulinchode bus stop, Pullur, Irinjalakuda, Kerala 680683


                                </p>
                            </div>
                        </div>
                        <!-- Contact Info Item End -->
                         
                        <!-- Contact Info Item Start -->
                        <div class="contact-info-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon-box">
                                <img src="<?= base_url('public/assets/template/images/icon-phone.svg')?>" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>contact us</h3>
                                <p><a href="#">(+91) 812 939 4980

                                </a></p>
                            </div>
                        </div>
                        <!-- Contact Info Item End -->

                        <!-- Contact Info Item Start -->
                        <div class="contact-info-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-box">
                                <img src="<?= base_url('public/assets/template/images/icon-mail.svg')?>" alt="">
                            </div>
                            <div class="contact-info-content">
                                <h3>email</h3>
                                <p><a href="#">drsudhanofficial.com

                                </a></p>
                            </div>
                        </div>
                        <!-- Contact Info Item End -->
                    </div>
                    <!-- Contact Info List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Contact Us End -->

    <!-- Contact Form Start -->
    <div class="conatct-us-form">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-6">
                    <!-- Contact Form Start -->
                    <div class="contact-form">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Have any questions?</h2>
                        </div>
                        <!-- Section Title End -->
                         
                        <!-- Contact Form Start -->
                        <form id="contactForm" action="#" method="POST" data-toggle="validator" class="wow fadeInUp">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone No." required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="email" name ="email" class="form-control" id="email" placeholder="Email Address" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-12 mb-5">
                                    <textarea name="message" class="form-control" id="message" rows="4" placeholder="Write Message..."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-btn">
                                        <button type="submit" class="btn-default"><span>submit now</span></button>
                                        <div id="msgSubmit" class="h3 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Contact Form End -->
                    </div>
                    <!-- Contact Form End -->
                </div>

                <!-- Google Map Start -->
                <div class="col-lg-6">
                    <!-- Google Map Iframe Start -->
                    <div class="google-map-iframe">

                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7849.922289844222!2d76.245572!3d10.344992!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba7f7eec402ff03%3A0xf66bb33a88c3fd51!2sSports%20Injury%20%26%20Joint%20Preservation%20Clinic!5e0!3m2!1sen!2sin!4v1761887357955!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- Google Map Iframe End -->
                </div>
                <!-- Google Map End -->
            </div>
        </div>
    </div>
    <!-- Contact Form End -->


    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>