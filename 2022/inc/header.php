<!-- header-start -->
<header>
  <div class="header-area ">
    <div class="header-top_area d-none d-lg-block">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-5 col-md-5 ">
            <div class="header_left">
              <p><i class="fas fa-map-marker-alt"></i> <?php echo $GLOBALS['config']['endereco']; ?></p>
            </div>
          </div>
          <div class="col-xl-7 col-md-7">
            <div class="header_right">
              <span><i class="fas fa-phone-alt"></i> <?php echo $GLOBALS['config']['telefone1']; ?></span>
              <span><i class="fas fa-phone-alt"></i> <?php echo $GLOBALS['config']['telefone2']; ?> </span>
              <span>
                <i class="fab fa-whatsapp"></i>
                <a target="blank"
                  href="https://api.whatsapp.com/send?phone=5547<?php echo str_replace("-", "", $GLOBALS['config']['celular']); ?>&text=Ol%C3%A1%20Santu%C3%A1rio%20SCJ!">
                  <?php echo $GLOBALS['config']['celular']; ?>
                </a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="address_bar d-none d-lg-block">
      <div class="container">
        <div class="row justify-content-between align-items-center">
          <div class="col-xl-4 col-lg-3">
            <div class="logo">
              <a href="index.html">
                <img class="img-fluid"
                  src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/logob.png"
                  alt="<?php echo $_SESSION['titulo_atual']; ?>">
              </a>
            </div>
          </div>
          <div class="col-xl-8 col-lg-9">
            <div class="header_right">
              <ul class="social-media-list text-right list-inline"">
              <li>
                <a href=" https://twitter.com/mark_heath" title="Facebook do Santuário">
                <i class="fab fa-facebook"></i>
                </a>
                </li>
                <li>
                  <a href="https://github.com/markheath">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
                <li>
                  <a href="https://www.youtube.com/channel/UChV2-HyJ9XzsKLQRztd7Pmw">
                    <i class="fab fa-youtube"></i>
                  </a>
                </li>
                <li>
                  <a href="https://stackoverflow.com/users/7532/mark-heath">
                    <i class="fab fa-twitter"></i>
                  </a>
                </li>
                <li>
                  <a href="https://stackoverflow.com/users/7532/mark-heath">
                    <i class="fab fa-whatsapp"></i>
                  </a>
                </li>
                <li>
                  <a href="https://stackoverflow.com/users/7532/mark-heath">
                    <i class="fab fa-telegram-plane"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="sticky-header" class="main-header-area">
      <div class="container">
        <div class="white_bg_bar">
          <div class="row align-items-center">
            <div class="col-12 d-lg-none">
              <div class="logo ">
                <a href="#">
                  <img
                    src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/logob.png"
                    alt="">
                </a>
              </div>
            </div>
            <div class="col-xl-8 col-lg-8">
              <div class="main-menu  d-none d-lg-block">
                <nav>
                  <ul id="navigation">
                    <li>Institucional <i class="ti-angle-down"></i>
                      <ul class="submenu">
                        <li><a href="<?php echo BASEURL; ?>project.html">Nossa História</a></li>
                        <li><a href="<?php echo BASEURL; ?>elements.html">Dehonianos</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Espiritualidade</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Sacerdotes</a></li>
                        <li><a href="<?php echo BASEURL; ?>about.html">Pastorais</a></li>
                      </ul>
                    </li>
                    <li>Notícias <i class="ti-angle-down"></i>
                      <ul class="submenu">
                        <li><a href="<?php echo BASEURL; ?>project.html">Notícias em Geral</a></li>
                        <li><a href="<?php echo BASEURL; ?>elements.html">Notícias da Paróquia</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Artigos</a></li>
                      </ul>
                    </li>
                    <li>Interatividade <i class="ti-angle-down"></i>
                      <ul class="submenu">
                        <li><a href="<?php echo BASEURL; ?>project.html">Agenda</a></li>
                        <li><a href="<?php echo BASEURL; ?>elements.html">Intenções</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Liturgia Diária</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Santo do dia</a></li>
                      </ul>
                    </li>
                    <li><a href="services.html">Seja dizimista</a></li>
                    <li>Contato <i class="ti-angle-down"></i>
                      <ul class="submenu">
                        <li><a href="<?php echo BASEURL; ?>project.html">Fale Conosco</a></li>
                        <li><a href="<?php echo BASEURL; ?>elements.html">Horários</a></li>
                        <li><a href="<?php echo BASEURL; ?>project_details.html">Localização</a></li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 d-none d-lg-block">
              <div class="Appointment d-flex justify-content-end">
                <div class="search_icon">
                  <a data-toggle="modal" data-target="#exampleModalCenter" href="#">
                    <i class="ti-search"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="mobile_menu d-block d-lg-none">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>
<!-- header-end -->