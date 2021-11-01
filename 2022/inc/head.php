<?php require_once DBAPI; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $_SESSION['titulo_atual']; ?></title>
  <meta name="description" content="">

  <!-- Contents -->
  <meta content="<?php echo $GLOBALS['config']['nome']; ?>" property="og:site_name" />
  <meta content="<?php echo $_SESSION['titulo_atual']; ?>" property="og:title" />
  <meta content='https://<?php echo $GLOBALS['config']['url']; ?>/<?php echo $_SESSION['imagem_atual']; ?>'
    property='og:image'>
  <meta content='<?php echo "https://".ABSLOCAL; ?>' property='og:url'>
  <meta content="<?php echo $_SESSION['descri_atual']; ?>" property="og:description" />
  <!-- Contents -->

  <!-- Names -->
  <meta name="language" content="Portuguese" />
  <meta name="URL" content="https://<?php echo $GLOBALS['config']['url']; ?>" />
  <meta name="subject" content="<?php echo $GLOBALS['config']['nome']; ?>" />
  <meta name="rating" content="GENERAL" />
  <meta name="updated" CONTENT="daily" />
  <meta name="robots" content="index, follow" />
  <meta name="audience" content="all" />
  <meta name="Publisher" CONTENT="<?php echo $GLOBALS['config']['url']; ?>" />
  <meta name="ia_archiver" content="index, follow" />
  <meta name="googlebot" content="index, follow" />
  <meta name="msnbot" content="index, follow" />
  <meta name="Search Engines" content="AltaVista, AOLNet, Infoseek, Excite, Hotbot, Lycos, Magellan, LookSmart, CNET" />
  <meta name="audience" content="all" />
  <meta name="revisit-after" content="1 days" />
  <meta name="document-classification" content="<?php echo $_SESSION['titulo_atual']; ?>" />
  <meta name="TITLE" content="<?php echo $_SESSION['titulo_atual']; ?>" />
  <meta name="Description" content="<?php echo $_SESSION['descri_atual']; ?>" />
  <meta name="Keywords" content="<?php echo $GLOBALS['config']['keyw']; ?>" lang="pt-br" xml:lang="pt-br" />
  <!-- Names -->

  <base href="https://<?php echo $GLOBALS['config']['url']; ?>/" target="_self">

  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo "http://".ABSLOCAL; ?>assets/img/favicon.ico">
  <!-- Place favicon.ico in the root directory -->

  <!-- CSS here -->
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/magnific-popup.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/gijgo.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/nice-select.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/flaticon.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/slicknav.css">

  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/scj.css">
  <link rel="stylesheet" href="<?php echo "http://".ABSLOCAL; ?>assets/css/jquery-ui.min.css">

  <link href="<?php echo "http://".ABSLOCAL; ?>assets/css/fontawesome.css" rel="stylesheet">
  <link href="<?php echo "http://".ABSLOCAL; ?>assets/css/brands.css" rel="stylesheet">
  <link href="<?php echo "http://".ABSLOCAL; ?>assets/css/solid.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="assets/css/responsive.css"> -->
</head>

<body>
  <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->