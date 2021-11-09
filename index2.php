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
    header('Location: '.URL_ROOT.'/login.php');
    //exit();
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PROMOMEDICS CRM</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="dist/css/site.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    
    <script type="text/javascript" src="dist/js/site.min.js"></script>
  </head>
  <body>
    <!--nav-->
    <nav role="navigation" class="navbar navbar-custom">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->

          <div class="container-fluid">

         <!--    <button data-target="#bs-content-row-navbar-collapse-5" data-toggle="collapse" class="navbar-toggler" type="button">
              <span class="navbar-toggler-icon"></span>
            </button> -->
            <a href="#" class="col-4">PROMOMEDICS
              
            </a>
            <!-- <div class="clear-fix"></div> -->
            <ul class="nav navbar navbar-right">
              <!-- <li class="active"><a href="getting-started.html">Getting Started</a></li>
              <li class="active"><a href="index.html">Documentation</a></li> -->
              <!-- <li class="disabled"><a href="#">Link</a></li> -->
              <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php if(isset($username)){echo $username;}?> <b class="caret"></b></a>
                <ul role="menu" class="dropdown-menu">
                    <?php 
                    if (isset($_SESSION['status'])) {
                       if($_SESSION['status'] != 3) {                   
                     ?>
                    <li><a  data-toggle="modal" href="#form-pass"><i class="fa fa-key pull-right"></i> Cambiar contraseña</a></li>
                    <?php  }
                    } ?>
                    <li class="dropdown-header"><a href="/core/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  <!-- <li class="dropdown-header">Setting</li>
                  <li><a href="#">Action</a></li>
                  <li class="divider"></li>
                  <li class="active"><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li class="disabled"><a href="#">Signout</a></li> -->
                </ul>
              </li>
            </ul>
           
          </div>
          <!--  <a href="#" class="navbar-brand">PROMOMEDICS</a> -->
          <!-- Collect the nav links, forms, and other content for toggling -->
       <!--    <div id="bs-content-row-navbar-collapse-5" class="collapse navbar-collapse"> -->
            

         <!--  </div> -->   <!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->
      </nav>
      
              
    <!--header-->
    <div class="container-fluid">
    <!--documents-->
        <div class="row row-offcanvas row-offcanvas-left">
          <div class="sidebar-offcanvas" role="navigation">
            <ul class="list-group panel">
                <!-- <li class="list-group-item"><i class="glyphicon glyphicon-align-justify"></i> <b>SIDE PANEL</b></li>
                <li class="list-group-item"><input type="text" class="form-control search-query" placeholder="Search Something"></li>
                <li class="list-group-item"><a href="index.html"><i class="glyphicon glyphicon-home"></i>Dashboard </a></li>
                <li class="list-group-item"><a href="icons.html"><i class="glyphicon glyphicon-certificate"></i>Icons </a></li>
                <li class="list-group-item"><a href="list.html"><i class="glyphicon glyphicon-th-list"></i>Tables and List </a></li>
                <li class="list-group-item"><a href="forms.html"><i class="glyphicon glyphicon-list-alt"></i>Forms</a></li>
                <li class="list-group-item"><a href="alerts.html"><i class="glyphicon glyphicon-bell"></i>Alerts</li>
                <li class="list-group-item"><a href="timeline.html" ><i class="glyphicon glyphicon-indent-left"></i>Timeline</a></li>
                <li class="list-group-item"><a href="calendars.html" ><i class="glyphicon glyphicon-calendar"></i>Calendars</a></li>
                <li class="list-group-item"><a href="typography.html" ><i class="glyphicon glyphicon-font"></i>Typography</a></li>
                <li class="list-group-item"><a href="footers.html" ><i class="glyphicon glyphicon-minus"></i>Footers</a></li>
                <li class="list-group-item"><a href="panels.html" ><i class="glyphicon glyphicon-list-alt"></i>Panels</a></li>
                <li class="list-group-item"><a href="navs.html" ><i class="glyphicon glyphicon-th-list"></i>Navs</a></li>
                <li class="list-group-item"><a href="colors.html" ><i class="glyphicon glyphicon-tint"></i>Colors</a></li>
                <li class="list-group-item"><a href="flex.html" ><i class="glyphicon glyphicon-th"></i>Flex</a></li>
                <li class="list-group-item"><a href="login.html" ><i class="glyphicon glyphicon-lock"></i>Login</a></li>
                <li> -->
             <!--      <a href="#demo3" class="list-group-item " data-toggle="collapse">Item 3  <span class="glyphicon glyphicon-chevron-right"></span></a>
                  <div class="collapse" id="demo3">
                    <a href="#SubMenu1" class="list-group-item" data-toggle="collapse">Subitem 1  <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <div class="collapse list-group-submenu" id="SubMenu1">
                      <a href="#" class="list-group-item">Subitem 1 a</a>
                      <a href="#" class="list-group-item">Subitem 2 b</a>
                      <a href="#SubSubMenu1" class="list-group-item" data-toggle="collapse">Subitem 3 c <span class="glyphicon glyphicon-chevron-right"></span></a>
                      <div class="collapse list-group-submenu list-group-submenu-1" id="SubSubMenu1">
                        <a href="#" class="list-group-item">Sub sub item 1</a>
                        <a href="#" class="list-group-item">Sub sub item 2</a>
                      </div>
                      <a href="#" class="list-group-item">Subitem 4 d</a>
                    </div>
                    <a href="javascript:;" class="list-group-item">Subitem 2</a>
                    <a href="javascript:;" class="list-group-item">Subitem 3</a>
                  </div>
                </li>
                <li>
                  <a href="#demo4" class="list-group-item " data-toggle="collapse">Item 4  <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <li class="collapse" id="demo4">
                      <a href="" class="list-group-item">Subitem 1</a>
                      <a href="" class="list-group-item">Subitem 2</a>
                      <a href="" class="list-group-item">Subitem 3</a>
                    </li>
                </li>-->
              
                  <?php 
                  if (isset($_SESSION['perm'])) {
                     $permArray = $_SESSION['perm'];
                  }
                    if (isset( $permArray)) {
                      # code...
                    
                    foreach ($permArray as $perm) {
                      if(isset($perm['children'])){
                        echo '<li>';
                        echo '<a href="#'.$perm['abrev'].'" class="list-group-item " data-toggle="collapse">'.$perm['nombre'].'  <span class="glyphicon glyphicon-chevron-right"></span></a>';
                        echo '<li class="collapse" id="'.$perm['abrev'].'">';
                        
                      
               
                      
                   
                        foreach ($perm['children'] as $mnu) {

                          echo '<a href="'.URL_ROOT.$mnu['url'].'" class="list-group-item">'.$mnu['nombre'].'</a>';
                           
                        }

                        echo '</li>';
                         echo '</li>';
                       
                      }
                      else{
                        // if($perm['url'] == '/medico' && ($usertype == 3 || $usertype == 4)) $perm['url'] .= '/'.$_SESSION['medico'];

                        // if($perm['url'] == '/gpomedico'){
                        //   if($perm['url'] == '/gpomedico' && ($usertype == 3 || $usertype == 4) && $_SESSION['grupo'] != 0){
                        //     $perm['url'] .= '/'.$_SESSION['grupo'];
                        //     echo '<li id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                        //   }
                        // }else{
                        //   echo '<li  id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                              echo '<a href="'.URL_ROOT.$perm['url'].'" class="list-group-item ">'.$perm['nombre'].'  <span class="glyphicon glyphicon-chevron-right"></span></a>';
                        // }
                        // 
                      }
                     

                    }
                      echo '<a href="'.URL_ROOT.'/calendario.php'.'" class="list-group-item ">'.'calendario  <span class="glyphicon glyphicon-chevron-right"></span></a>';



                  } //FIN DEL ISSET
                   ?>



              </ul> 

          </div>

          <div class="container-fluid">
              <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a> Panel de Control</h3>
              </div>
              <div class="panel-body">
                   <div class="content-row">
                      <div class="row">