<?php
if ( ! session_id() ) @ session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>SIAL</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php    
require_once("autoload.php");

  $page = (!empty($_GET["page"]))? $_GET["page"]:"";  ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar">3</span>
            <span class="icon-bar">2</span>
            <span class="icon-bar">1</span>
          </button>
          <a class="navbar-brand" href="">SIAL</a>
          
        </div>
        <div id="navbar" class="navbar-collapse collapse">          
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
         
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <!--
              <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
              <li <?php echo ($page=="main")?"class=\"active\"":""; ?> ><a href="?page=main">Overview</a></li>
              <li <?php echo ($page=="report")?"class=\"active\"":""; ?> ><a href="?page=report">Report</a></li>
              <li><a href="#">Reports</a></li>
              <li><a href="#">Venta</a></li>
              <li><a href="#">Export</a></li>
             -->
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php echo ($page=="producto")?"class=\"active\"":""; ?> ><a href="?page=producto">Nuevo Producto</a></li>
            <li <?php echo ($page=="productos")?"class=\"active\"":""; ?> ><a href="?page=productos">Productos</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php echo ($page=="venta")?"class=\"active\"":""; ?> ><a href="?page=venta">Venta</a></li>
            <li <?php echo ($page=="off")?"class=\"active\"":""; ?> ><a href="?page=ventaOff&act=off">Vaciar Venta</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php echo ($page=="movimientos")?"class=\"active\"":""; ?> ><a href="?page=movimientos">Movimiento</a></li>
            <li <?php echo ($page=="ingreso")?"class=\"active\"":""; ?> ><a href="?page=ingreso">Ingreso</a></li>
            <li <?php echo ($page=="salida")?"class=\"active\"":""; ?> ><a href="?page=salida">Salida</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php echo ($page=="medida")?"class=\"active\"":""; ?> ><a href="?page=medida">Unidad de medida</a></li>
            <li <?php echo ($page=="marca")?"class=\"active\"":""; ?> ><a href="?page=marca">Marca</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          
          
<!--
  <div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Label</h4>
      <span class="text-muted">Something else</span>
    </div>
  </div>
  <h2 class="sub-header">Section title</h2>
-->
          <div class="table-responsive">
            <?php 


              require_once('body.php'); 


            ?>
            
            
          </div>
          <div class="col-sm-4  col-md-4  main"><pre><h4>GET</h4>
          <?php print_r ($_GET);?></pre></div>
          <div class="col-sm-4  col-md-4  main"><pre><h4>POST</h4>
          <?php print_r ($_POST);?></pre></div>
          <div class="col-sm-4  col-md-4  main"><pre><h4>SESSION</h4>
          <?php print_r ($_SESSION);?></pre></div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
