<?php require_once 'config.php'; ?>
<?php require_once DBAPI; ?>

<?php include(HEAD_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php $db = open_database(); ?>

<?php if ($db) : ?>

<?php
$banners = null;
$banner = null;

// $banners=find_query("SELECT empresa, site, img FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC");
$result = mysqli_query($db, "SELECT empresa, site, img FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC");
?>

<!-- slider_area_start -->
<?php if ($result) : ?>
<div class="slider_area">
  <div class="slider_active owl-carousel">
    <?php while($record = mysqli_fetch_array($result)){ ?>
    <div class="single_slider  d-flex align-items-center overlay" style="background-image: url("
      <?php echo "https://" . utf8_encode($GLOBALS['config']['url']) . "/" . str_replace("", "/", $record['img']); ?>")>
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-9 col-md-9 col-md-12">
            <div class="slider_text text-center">
              <h3><?php echo utf8_encode($record['empresa']); ?></h3>
              <a href="<?php echo $record['site']; ?>" class="boxed-btn3">Our Services</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<?php endif; ?>
<!-- slider_area_end -->

<!-- features_area_start -->
<div class="features_area">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-4 col-md-4">
        <div class="single_feature text-center">
          <div class="icon">
            <i class="flaticon-sketch"></i>
          </div>
          <h3>Creative Plan & Design</h3>
          <p>There are many variations of passages of lorem Ipsum available, but the majority have
            suffered alteration.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="single_feature text-center">
          <div class="icon">
            <i class="flaticon-helmet"></i>
          </div>
          <h3>Talented Peoples</h3>
          <p>There are many variations of passages of lorem Ipsum available, but the majority have
            suffered alteration.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="single_feature text-center">
          <div class="icon">
            <i class="flaticon-support"></i>
          </div>
          <h3>Modern Tools</h3>
          <p>There are many variations of passages of lorem Ipsum available, but the majority have
            suffered alteration.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- features_area_end -->

<!-- about_area_start  -->
<div class="about_area">
  <div class="container">
    <div class="border_1px">
      <div class="row align-items-center">
        <div class="col-xl-6  col-md-6">
          <div class="about_thumb">
            <img
              src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/about/about.png"
              alt="">
            <div class="pattern_img d-none d-lg-block">
              <img
                src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/pattern/pattern.svg"
                alt="">
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-6">
          <div class="about_info">
            <h3>We Serve all of your <br>
              Construction Services</h3>
            <p class="first_para"> “Construction is a full service construction company offering
              building solutions from start to finish. Our staff has been operating on NYC for ten
              years.</p>
            <p>There are many variations of passages of lorem Ipsum available, but the majority have
              suffered alteration in some form, by injected humour, or randomised words which don't
              look even slightly believable.</p>
            <a href="about.html" class="boxed-btn3">About Us</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- about_area_end  -->

<!-- service_area_start  -->
<div class="service_area">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="section_title text-center mb-50">
          <h3>Our Services</h3>
        </div>
      </div>
    </div>
    <div class="border_bottom_1px position-relative">
      <div class="pattern_img d-none d-xl-block">
        <img
          src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/pattern/pattern.png"
          alt="">
      </div>
      <div class="row">
        <div class="col-xl-12">
          <div class="service_active owl-carousel">
            <div class="single_service">
              <div class="thumb">
                <img
                  src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/service/1.png"
                  alt="">
              </div>
              <div class="service_info">
                <a href="#">
                  <h3>maintenance & Repair </h3>
                </a>
                <p>There are many variations of passages of lorem Ipsum available.</p>
                <a class="d-flex align-items-center" href="#">More <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
            <div class="single_service">
              <div class="thumb">
                <img
                  src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/service/2.png"
                  alt="">
              </div>
              <div class="service_info">
                <a href="#">
                  <h3>Building Construction</h3>
                </a>
                <p>There are many variations of passages of lorem Ipsum available.</p>
                <a class="d-flex align-items-center" href="#">More <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
            <div class="single_service">
              <div class="thumb">
                <img
                  src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/service/3.png"
                  alt="">
              </div>
              <div class="service_info">
                <a href="#">
                  <h3>Bridge & Road Construction</h3>
                </a>
                <p>There are many variations of passages of lorem Ipsum available.</p>
                <a class="d-flex align-items-center" href="#">More <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
            <div class="single_service">
              <div class="thumb">
                <img
                  src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/service/1.png"
                  alt="">
              </div>
              <div class="service_info">
                <a href="#">
                  <h3>maintenance & Repair </h3>
                </a>
                <p>There are many variations of passages of lorem Ipsum available.</p>
                <a class="d-flex align-items-center" href="#">More <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- service_area_end  -->

<!-- gallery_area-START -->
<div class="gallery_area">
  <div class="container">
    <div class="gallery_nav">
      <div class="row align-items-center">
        <div class="col-lg-8 col-md-6">
          <h3 class="gallery_title">Take a look Some of our <br>
            awesome projects</h3>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="portfolio-menu">
            <button class="active" data-filter="*">All</button>
            <button data-filter=".cat1">Architecture</button>
            <button data-filter=".cat2">Buildings</button>
            <button data-filter=".cat3">Bridges</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0">
    <div class="row grid no-gutters">
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat3 cat3">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/1.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat3">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/2.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat2">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/3.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat1 cat3">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/4.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat2 cat3 cat4">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/5.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat1 cat2">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/6.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat4 cat1">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/7.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 grid-item cat1 cat2 cat3 cat4">
        <div class="single_gallery">
          <div class="thumb">
            <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/gallery/8.png"
              alt="">
          </div>
          <div class="gallery_hover">
            <div class="hover_inner d-flex align-items-center justify-content-between">
              <h3>Maintenance & Repair</h3>
              <div class="icon">
                <a href="project_details.html">
                  <i class="ti-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- gallery_area-END -->

<!-- more_pro_btn_start  -->
<a href="project.html" class="more_pro_btn">More Projects</a>
<!-- more_pro_btn_end  -->

<!-- chose_us_area start -->
<div class="chose_us_area chose_bg_1">
  <div class="container">
    <div class="row justify-content-end">
      <div class="col-lg-6 col-md-8">
        <div class="chose_info">
          <h3>Why Choose Us?</h3>
          <p class="lasrge_text">
            “Construction is a full service construction company offering building solutions from start
            to finish. Our staff has been operating on NYC for ten years.
          </p>
          <p>There are many variations of passages of lorem Ipsum available, but the majority have
            suffered alteration in some form, by injected.</p>
          <div class="icon_video">
            <a class="popup-video" href="https://www.youtube.com/watch?v=Spi1vvZgLXw">
              <i class="fa fa-caret-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- chose_us_area end -->
<div class="testimonial_area ">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="section_title text-center mb-55">
          <h3>Testimonials</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <div class="testmonial_active owl-carousel">
          <div class="single_carousel">
            <div class="single_testmonial text-center">
              <div class="testmonial_author">
                <div class="thumb">
                  <img
                    src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/testimonial/1.png"
                    alt="">
                </div>
                <h4>Jordan Adams</h4>
                <span>Client</span>
              </div>
              <p>“Our program is guided by the developmental milestones which embrace <br>
                the six most important learning domains in education”</p>
            </div>
          </div>
          <div class="single_carousel">
            <div class="single_testmonial text-center">
              <div class="testmonial_author">
                <div class="thumb">
                  <img
                    src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/testimonial/1.png"
                    alt="">
                </div>
                <h4>Jordan Adams</h4>
                <span>Client</span>
              </div>
              <p>“Our program is guided by the developmental milestones which embrace <br>
                the six most important learning domains in education”</p>
            </div>
          </div>
          <div class="single_carousel">
            <div class="single_testmonial text-center">
              <div class="testmonial_author">
                <div class="thumb">
                  <img
                    src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/testimonial/1.png"
                    alt="">
                </div>
                <h4>Jordan Adams</h4>
                <span>Client</span>
              </div>
              <p>“Our program is guided by the developmental milestones which embrace <br>
                the six most important learning domains in education”</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- contact_us_start  -->
<div class="contact_us overlay">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 col-md-7">
        <div class="contact_text">
          <h3>Are you looking for a Construction
            and Industrial Experts?</h3>
        </div>
      </div>
      <div class="col-lg-4 col-md-5">
        <div class="contact_btn">
          <a class="boxed-btn3" href="contact.html">Contact Us</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- contact_us_end -->


<?php else : ?>
<div class="alert alert-danger" role="alert">
  <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
</div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
<?php include(FOOT_TEMPLATE); ?>