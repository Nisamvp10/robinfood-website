<?= view('frontend/inc/header') ?>
<link rel="stylesheet" href="<?= base_url('public/assets/template/') ?>css/magnific-popup.css">


	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque">
                         Gallery

                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Gallery</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>




    <!-- Page Contact Us Start -->
    <div class="page-gallery">
        <div class="container">
            <!-- gallery section start -->
            <div class="row gallery-items page-gallery-box">
                <?php
                if(!empty($gallery)){
                    foreach($gallery as $img) {
                    ?>
                     <div class="col-lg-4 col-6">
                    <!-- Image Gallery start -->
                    <div class="photo-gallery wow fadeInUp">
                        <a href="<?=validImg($img['image']) ?> ?>" data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="<?= validImg($img['image']) ?>" alt="">
                            </figure>
                        </a>
                    </div>
                    <!-- Image Gallery end -->
                </div>

                    <?php
                    }
                }?>
               
              
            </div>
            <!-- gallery section end -->
        </div>
    </div>


    <!-- Page Contact Us End -->

   <?= view('frontend/inc/footerLink') ?>
</body>

</html>