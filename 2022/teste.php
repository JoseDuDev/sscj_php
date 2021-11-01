<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php echo '//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);?>
  <br>
  <?php echo $_SERVER['REQUEST_URI'] . '/2022/';?>
  <br>
</body>

</html>