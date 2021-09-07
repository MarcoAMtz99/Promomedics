<?php /*echo "403. Access denied. "; exit(0);*/
  include 'core/conex.php';

  $title = isset($titulo) ? $titulo.' | ' : '';
  $title .= PAGE_TITLE;

  if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $transcurrido = time() - $_SESSION['last'];
    $session_error = false;
    //if($transcurrido > 1200){
    if($transcurrido > 1200){
      /*$_SESSION["user"] = null;
      $_SESSION["last"] = null;
      unset($_SESSION["user"]);
      unset($_SESSION["last"]);
      session_unset();
      session_regenerate_id(true);
      session_destroy();

      header('Location: '.URL_ROOT.'/login?session=0');*/
      header('Location: '.URL_ROOT.'/core/logout.php?session=0');
    }else{
      $_SESSION['last'] = time();

        if(isset($_SESSION['nomuser'])){ 
            $username = $_SESSION['nomuser'];
        }
      
      $usertype = $_SESSION['perfil'];
    }
  }else{
    header('Location: '.URL_ROOT.'/login');
    //exit();
  }

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/manifest.json">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/fullcalendar.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/moment.min.js"></script>
		<script src="js/fullcalendar.min.js"></script>
		<script src="js/es.js"></script>
    
    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
    
    <!-- Custom Theme Style >
    <link href="/build/css/custom.min.css" rel="stylesheet"-->
    <link href="/build/css/custom.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->

<!--  		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109157959-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-109157959-1');
    </script>

  </head>

  <body class="nav-sm">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            
            <?php include 'sidebar.php'; ?>

          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav navbar-fixed-top">
          
          <?php include 'topmenu.php'; ?>

        </div>
        <!-- /top navigation -->