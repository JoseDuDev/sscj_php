<?php 
require_once 'config.php'; 
require_once DBAPI; 
require_once DBAPIQUERY; 

require_once GERAIS; 
require_once FUNCOES; 

ob_start();
date_default_timezone_set('America/Sao_Paulo');

include(HEAD_TEMPLATE); 
include(HEADER_TEMPLATE); 
$db = open_database(); 

if ($db) : 

$result = consultar("SELECT id, empresa, site, img FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC");
?>

<!-- slider_area_start -->
<?php if ($result) : ?>
<div class="slider_area">
  <div class="slider_active owl-carousel">
    <?php 
    while($row = $result->fetch_assoc()){ 
      $imagem = "http://" . utf8_encode($GLOBALS['config']['url']);
      $imagem .= "/area" . "/" . $row['img'];
    ?>
    <div class="single_slider  d-flex align-items-center overlay"
      style="background-image: url('<?php echo $imagem; ?>')">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-9 col-md-9 col-md-12">
            <div class="slider_text text-center" id="banner<?php echo $row["id"]; ?>">
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
<div class="container">
  <div class="features_area">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-lg-3 col-md-6">
          <a href="<?php echo "http://" . utf8_encode($GLOBALS['config']['url']); ?>liturgia_diaria.php"
            title="Liturgia Diária">
            <div class="single_feature text-center">
              <div class="icon">
                <i class="fas fa-bible"></i>
              </div>
              <h3>Liturgia Diária</h3>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="<?php echo "http://" . utf8_encode($GLOBALS['config']['url']); ?>santododia.php"
            title="Santo do dia">
            <div class="single_feature text-center">
              <div class="icon">
                <i class="fas fa-cross"></i>
              </div>
              <h3>Santo do dia</h3>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="<?php echo "http://" . utf8_encode($GLOBALS['config']['url']); ?>horarios.php"
            title="Horários das missas">
            <div class="single_feature text-center">
              <div class="icon">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <h3>Horários</h3>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="<?php echo "http://" . utf8_encode($GLOBALS['config']['url']); ?>dizimo.php" title="Seja dizimista">
            <div class="single_feature text-center">
              <div class="icon">
                <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/dizimo.png" alt="Logo dízimo">
              </div>
              <h3>Seja dizimista</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- features_area_end -->

<!-- service_area_start  -->
<div class="container">
  <div class="row">
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">
      <div class="features_agenda">
        <div class="section_title text-center mb-20">
          <h3>Agenda</h3>
        </div>

        <div class="ultimos_eventos">
          <span class="badge badge-secundary text-wrap">30/10/2021</span>
          <p class="text-secondary">.text-secondary</p>
        </div>
      </div>
    </div>
    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-12">
      <div class="service_area">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="section_title text-center mb-20">
                <h3>Últimas notícias</h3>
              </div>
            </div>
          </div>
          <div class="border_bottom_1px position-relative">
            <div class="pattern_img d-none d-xl-block">
              <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/pattern/pattern.png" alt="">
            </div>
            <div class="row">
              <div class="col-xl-12">
                <div class="service_active owl-carousel">
                  <?php
            //$result = consultar("SELECT id, empresa, site, img FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC");
            ?>
                  <div class="single_service">
                    <div class="thumb">
                      <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/service/1.png" alt="">
                    </div>
                    <div class="service_info">
                      <a href="#">
                        <h3>maintenance & Repair </h3>
                      </a>
                      <p>There are many variations of passages of lorem Ipsum available.</p>
                      <a class="d-flex align-items-center" href="#">Leia mais <i class="ti-angle-right"></i>
                      </a>
                    </div>
                  </div>

                  <div class="single_service">
                    <div class="thumb">
                      <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/service/2.png" alt="">
                    </div>
                    <div class="service_info">
                      <a href="#">
                        <h3>Building Construction</h3>
                      </a>
                      <p>There are many variations of passages of lorem Ipsum available.</p>
                      <a class="d-flex align-items-center" href="#">Leia mais <i class="ti-angle-right"></i>
                      </a>
                    </div>
                  </div>
                  <div class="single_service">
                    <div class="thumb">
                      <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/service/3.png" alt="">
                    </div>
                    <div class="service_info">
                      <a href="#">
                        <h3>Bridge & Road Construction</h3>
                      </a>
                      <p>There are many variations of passages of lorem Ipsum available.</p>
                      <a class="d-flex align-items-center" href="#">Leia mais <i class="ti-angle-right"></i>
                      </a>
                    </div>
                  </div>
                  <div class="single_service">
                    <div class="thumb">
                      <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/service/1.png" alt="">
                    </div>
                    <div class="service_info">
                      <a href="#">
                        <h3>maintenance & Repair </h3>
                      </a>
                      <p>There are many variations of passages of lorem Ipsum available.</p>
                      <a class="d-flex align-items-center" href="#">Leia mais <i class="ti-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- service_area_end  -->

<div class="padroeiro" data-scroll-reveal="enter from the left after 0.2s" data-scroll-reveal-initialized="true"
  data-scroll-reveal-complete="true">
  <div class="container">
    <div class="util">
      <a href="./institucional/padroeiro"><img src="<?php echo "http://".ABSLOCAL; ?>assets/img/icone_scj.jpg" width=""
          height="" title="SÃO LUÍS GONZAGA" alt="SÃO LUÍS GONZAGA">
        <h3>SÃO LUÍS GONZAGA</h3>
        <p>Luís Gonzaga nasceu no dia 9 de março de 1568, no Castelo de Castiglione delle Stivieri, na Lombardia
          (Itália).
          Era primogênito de Ferrante, Marquês de Castiflione e de Marta Tana Santena. O pai ocupava lugar de destaque
          na
          corte de Felipe II, da Espanha, e a mãe era dama de honra da Rainha. Luís, por ser filho mais velho, tinha
          direito à sucessão dos títulos honoríficos e era herdeiro natural do feudo do pai.

          A Infância
          O marquês de Castiglione queria preparar o filho para as funções a que era destinado: ser um grande soldado.
          Possibilitou que o menino, desde a mais tenra idade, tivesse contato com o ambiente militar, seja através de
          brinquedos e jogos (miniaturas de armas e morteiros), seja freqüentando um acampamento onde estavam sendo
          treinados 3 mil soldados para a expedição da Espanha contra a Túnis.

          A mãe preocupava-se em dar-lhe uma educação cristã. E, desde menino, Luís fazia diariamente suas orações de
          manhã e à noite; apenas com sete anos ...<br><br>Leia mais</p>
      </a>
      <div class="clearfix">&nbsp;</div>
      <div class="intro-geral"><span>Capela Virtual</span></div>
      <div class="capela">
        <ul>
          <a href="./liturgia-diaria/2021-10-29/">
            <li class="capela1">&nbsp;</li>
          </a>
          <a href="./santo-do-dia/2021-10-29/">
            <li class="capela2">&nbsp;</li>
          </a>
          <a href="./capela">
            <li class="capela3">&nbsp;</li>
          </a>
        </ul>
      </div>
      <div class="clearfix">&nbsp;</div>
    </div>
  </div>
</div>

<!-- about_area_start  -->
<div class="about_area">
  <div class="container">
    <div class="border_1px">
      <div class="row align-items-center">
        <div class="col-xl-6  col-md-6">
          <div class="about_thumb">
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/about/about.png" alt="">
            <div class="pattern_img d-none d-lg-block">
              <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/pattern/pattern.svg" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/1.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/2.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/3.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/4.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/5.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/6.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/7.png" alt="">
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
            <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/gallery/8.png" alt="">
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

<!-- chose_us_area start -->
<?php 
  $data = date("d/m");
?>
<div class="chose_us_area"
  style="background-image: url(<?php echo "http://".ABSLOCAL; ?>assets/img/banner/chose_banner2.png);">
  <div class="container">
    <div class="row justify-content-end">
      <div class="col-lg-6 col-md-8">
        <div class="chose_info">
          <h3>Santo do dia</h3>
          <p class="lasrge_text">
            <?php echo $data; ?> Dia de Sáo Fulano
          </p>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0"
              allowfullscreen></iframe>
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
                  <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/testimonial/1.png" alt="">
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
                  <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/testimonial/1.png" alt="">
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
                  <img src="<?php echo "http://".ABSLOCAL; ?>assets/img/testimonial/1.png" alt="">
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



<!-- <div class="fluid-container" style="align-itens: center;">
  <div class="modal fade" id="cookieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="notice d-flex justify-content-between align-items-center">
            <div class="cookie-text">This website uses cookies to personalize content and analyse traffic in order to
              offer you a better experience.</div>
            <div class="buttons d-flex flex-column flex-lg-row">
              <a href="#a" class="btn btn-success btn-sm" data-dismiss="modal">Aceito</a>
              <a href="#a" class="btn btn-secondary btn-sm" data-dismiss="modal">Leia mais</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<?php else : ?>
<div class="alert alert-danger" role="alert">
  <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
</div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
<?php include(FOOT_TEMPLATE); ?>