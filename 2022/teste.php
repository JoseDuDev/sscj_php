<?php 
include(HEAD_TEMPLATE); 
include(HEADER_TEMPLATE); 

$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Falha de conexão: " . $conn->connect_error);
}

$sql = "SELECT empresa, site, img FROM banner WHERE status='S' AND local='principal' ORDER BY id_o DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  ?>
<div class="slider_area">
  <div class="slider_active owl-carousel">
    <?php
  while($row = $result->fetch_assoc()) {
    $imagem = "https://" . utf8_encode($GLOBALS['config']['url']);
    $imagem .= "/" . $row['img'];
?>
    <div class="single_slider  d-flex align-items-center overlay"
      style="background-image: url('<?php echo $imagem ?>')">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-9 col-md-9 col-md-12">
            <div class="slider_text text-center" id="banner<?php echo $row["id"]; ?>">
              <h3><?php echo utf8_encode($row["empresa"]); ?></h3>
              <a href="<?php echo $row['site']; ?>" class="boxed-btn3">Our Services</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      }
      ?>
  </div>
</div>
<?php
  }
$conn->close();
?>

<?php include(FOOTER_TEMPLATE); ?>
<?php include(FOOT_TEMPLATE); ?>