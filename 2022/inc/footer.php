</body>

<!-- footer_start  -->
<footer class="footer">
  <div class="download_brochure">
    <div class="container">
      <div class="bordered_1px">
        <div class="row">
          <div class="col-lg-5 col-md-5">
            <div class="footer_logo">
              <a href="#">
                <img src="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI']; ?>assets/img/logob.png"
                  alt="">
              </a>
            </div>
          </div>
          <div class="col-lg-7 col-md-7">
            <h3 class="footer_title">
              Inscreva-se
            </h3>
            <form action="#" class="form-inline">
              <div class="form-group mb-2 espacamento6dir">
                <input type="text" class="form-control form-control-sm" id="nome" placeholder="Nome">
              </div>
              <div class="form-group mb-2 espacamento6dir">
                <input type="email" class="form-control form-control-sm" id="email" placeholder="E-mail">
              </div>
              <button type="submit" class="btn btn-primary mb-2 form-control-sm">Enviar</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="footer_top">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-md-6 col-lg-6">
          <div class="footer_widget">
            <h3 class="footer_title">
              <?php echo $GLOBALS['config']['nome']; ?>
            </h3>
            <p><?php echo $GLOBALS['config']['endereco']; ?><br>
              <span class="espacamento6dir"><i class="fas fa-phone-alt"></i>
                <?php echo $GLOBALS['config']['telefone1']; ?></span>
              <span class="espacamento6dir"><i class="fas fa-phone-alt"></i>
                <?php echo $GLOBALS['config']['telefone2']; ?> </span>
              <span>
                <i class="fab fa-whatsapp"></i>
                <a target="blank"
                  href="https://api.whatsapp.com/send?phone=5547<?php echo str_replace("-", "", $GLOBALS['config']['celular']); ?>&text=Ol%C3%A1%20Santu%C3%A1rio%20SCJ!">
                  <?php echo $GLOBALS['config']['celular']; ?>
                </a>
              </span>
              <br>
              <br>
              <strong>Horário de Atendimento - Scretaria</strong>
              <br>
              <?php echo $GLOBALS['config']["msg3"]; ?>
            </p>
            <div class="socail_links">
              <ul>
                <li>
                  <a href="#">
                    <i class="ti-facebook"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="ti-twitter-alt"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fab fa-youtube"></i>
                  </a>
                </li>
              </ul>
            </div>

          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-3">
          <div class="footer_widget">
            <h3 class="footer_title">
              Popular Searches
            </h3>
            <ul>
              <li><a href="#">Apartment for rent </a></li>
              <li><a href="#">Office for rent</a></li>
              <li><a href="#"> Apartment for sale</a></li>
              <li><a href="#"> Luxuries</a></li>
            </ul>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-3">
          <div class="footer_widget">
            <h3 class="footer_title">
              Useful Links
            </h3>
            <ul>
              <li><a href="<?php echo BASEURL; ?>sobre.php">About</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#"> Contact</a></li>
              <li><a href="#"> Appointment</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copy-right_text">
    <div class="container">
      <div class="footer_border"></div>
      <div class="row">
        <div class="col-xl-9">
          <p class="copy_right text-center">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. 
          Copyright © Paróquia São Luís Gonzaga. Todos os direitos reservados-->
            Copyright &copy;<script>
            document.write(new Date().getFullYear());
            </script>&nbsp;&nbsp;Santuário Sagrado Coração de Jesus. Todos os direitos reservados.</i>
          </p>
        </div>
        <div class="col-xl-3">
          <p class="copy_right text-center">Desenvolvido por <a href="" title="Desenvolvedor José Eduardo">José
              Eduardo</a></p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- footer_end  -->