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
    <title>Bootflat-Admin Template</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="dist/css/site.min.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="dist/js/site.min.js"></script>
  </head>
  <body>
    <!--nav-->
    <nav role="navigation" class="navbar navbar-custom">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button data-target="#bs-content-row-navbar-collapse-5" data-toggle="collapse" class="navbar-toggle" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">PROMOMEDICS</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div id="bs-content-row-navbar-collapse-5" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
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
                    <li><a data-toggle="modal" href="#form-pass"><i class="fa fa-key pull-right"></i> Cambiar contraseña</a></li>
                    <?php  }
                    } ?>
                  <li class="dropdown-header">Setting</li>
                  <li><a href="#">Action</a></li>
                  <li class="divider"></li>
                  <li class="active"><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li class="disabled"><a href="#">Signout</a></li>
                </ul>
              </li>
            </ul>

          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    <!--header-->
    <div class="container-fluid">
    <!--documents-->
        <div class="row row-offcanvas row-offcanvas-left">
          <div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
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
                      // if(isset($perm['children'])){
                      //   echo '<li  id="mnu-'.$perm['abrev'].'"><a><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].' <span class="fa fa-chevron-down"></span></a>';
                      //   echo '<ul class="nav child_menu">';

                      //   foreach ($perm['children'] as $mnu) {
                      //     echo '<li  id="mnu-'.$mnu['abrev'].'"><a href="'.URL_ROOT.$mnu['url'].'">'.$mnu['nombre'].'</a></li>';
                      //   }

                      //   echo "</ul>";
                      //   echo "</li>";
                      // }else{
                      //   if($perm['url'] == '/medico' && ($usertype == 3 || $usertype == 4)) $perm['url'] .= '/'.$_SESSION['medico'];

                      //   if($perm['url'] == '/gpomedico'){
                      //     if($perm['url'] == '/gpomedico' && ($usertype == 3 || $usertype == 4) && $_SESSION['grupo'] != 0){
                      //       $perm['url'] .= '/'.$_SESSION['grupo'];
                      //       echo '<li id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                      //     }
                      //   }else{
                      //     echo '<li  id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                      //   }
                      // }
                      echo '<li class="list-group-item"><a href="'.URL_ROOT.$perm['url'].'" ><i class="glyphicon glyphicon-align-justify"></i><b>'.$perm['nombre'].'</b></a></li>';

                    }


                  } //Fin del if para validar isset 
                    echo' <li id="mnu-cal"><a href="'.URL_ROOT.'/calendario.php"><i class="glyphicon glyphicon-calendar"></i> Agenda</a></li>';
                    echo '<li class="list-group-item"><i class="glyphicon glyphicon-align-justify"></i> <b>SIDE PANEL</b></li>';
                  ?>




              </ul> 

          </div>
          <div class="col-xs-12 col-sm-9 content">
              <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a> Panel de Control</h3>
              </div>
              <div class="panel-body">
                   <div class="content-row">
                      iv class="row">
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#5D9CEC" class="pull-left light"></div>
                              <div style="background-color:#4A89DC" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>BLUE JEANS</h4>
                              <p>#5D9CEC, #4A89DC</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#4FC1E9" class="pull-left light"></div>
                              <div style="background-color:#3BAFDA" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>AQUA</h4>
                              <p>#4FC1E9, #3BAFDA</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#48CFAD" class="pull-left light"></div>
                              <div style="background-color:#37BC9B" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>MINT</h4>
                              <p>#48CFAD, #37BC9B</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#A0D468" class="pull-left light"></div>
                              <div style="background-color:#8CC152" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>GRASS</h4>
                              <p>#A0D468, #8CC152</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#FFCE54" class="pull-left light"></div>
                              <div style="background-color:#F6BB42" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>SUNFLOWER</h4>
                              <p>#FFCE54, #F6BB42</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="color-swatches">
                          <div class="swatches">
                            <div class="clearfix">
                              <div style="background-color:#FC6E51" class="pull-left light"></div>
                              <div style="background-color:#E9573F" class="pull-right dark"></div>
                            </div>
                            <div class="infos">
                              <h4>BITTERSWEET</h4>
                              <p>#FC6E51, #E9573F</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     </div>
              </div>
              </div>
        </div><!-- content -->
      </div>
    </div>
    <!--footer-->
    <div class="site-footer">
      <div class="container">
        <div class="download">
          <span class="download__infos">You simply have to <b>try it</b>.</span>&nbsp;&nbsp;&nbsp;&nbsp;
          <a class="btn btn-primary" href="https://github.com/silverbux/bootflat-admin/archive/master.zip">Download Bootflat-Admin</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- SmartAddon BEGIN -->
            <script type="text/javascript">
            (function() {
            var s=document.createElement('script');s.type='text/javascript';s.async = true;
            s.src='http://s1'+'.smartaddon.com/share_addon.js';
            var j =document.getElementsByTagName('script')[0];j.parentNode.insertBefore(s,j);
            })();
            </script>

            <a href="http://www.smartaddon.com/?share" title="Share Button" onclick="return sa_tellafriend('','bookmarks')"><img alt="Share" src="http://bootflat.github.io/img/share.gif" border="0" /></a>
            <!-- SmartAddon END -->
        </div>
        <hr class="dashed" />
        <div class="row">
          <div class="col-md-4">
            <h3>Get involved</h3>
            <p>Bootflat is hosted on <a href="https://github.com/silverbux/bootflat-admin" target="_blank" rel="external nofollow">GitHub</a> and open for everyone to contribute. Please give us some feedback and join the development!</p>
          </div>
          <div class="col-md-4">
            <h3>Contribute</h3>
            <p>You want to help us and participate in the development or the documentation? Just fork Bootflat on <a href="https://github.com/silverbux/bootflat-admin" target="_blank" rel="external nofollow">GitHub</a> and send us a pull request.</p>
          </div>
          <div class="col-md-4">
            <h3>Found a bug?</h3>
            <p>Open a <a href="https://github.com/silverbux/bootflat-admin/issues" target="_blank" rel="external nofollow">new issue</a> on GitHub. Please search for existing issues first and make sure to include all relevant information.</p>
          </div>
        </div>
        <hr class="dashed" />
        <div class="row">
          <div class="col-md-6">
            <h3>Talk to us</h3>
            <ul>
              <li>Tweet us at <a href="https://twitter.com" target="_blank">@YourTwitter</a>&nbsp;&nbsp;&nbsp;&nbsp;Email us at <span class="connect">info@yourdomain.com</span></li>
              <li>
                <a title="Twitter" href="https://twitter.com" target="_blank" rel="external nofollow"><i class="icon" data-icon="&#xe121"></i></a>
                <a title="Facebook" href="https://www.facebook.com" target="_blank" rel="external nofollow"><i class="icon" data-icon="&#xe10b"></i></a>
                <a title="Google+" href="https://plus.google.com/" target="_blank" rel="external nofollow"><i class="icon" data-icon="&#xe110"></i></a>
                <a title="Github" href="https://github.com/alexquiambao" target="_blank" rel="external nofollow"><i class="icon" data-icon="&#xe10e"></i></a>
              </li>
            </ul>
          </div>
          <div class="col-md-6">
            <!-- Begin MailChimp Signup Form -->
            <link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
            <div id="mc_embed_signup">
            <h3 style="margin-bottom: 15px;">Newsletter</h3>
            <form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
                <input style="margin-bottom: 10px;" type="email" value="" name="EMAIL" class="email form-control" id="mce-EMAIL" placeholder="email address" required>
                <span class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary"></span>
            </form>
            </div>
            <!--End mc_embed_signup-->
          </div>
        </div>
        <hr class="dashed" />
        <div class="copyright clearfix">
          <p><b>Bootflat</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="getting-started.html">Getting Started</a>&nbsp;&bull;&nbsp;<a href="index.html">Documentation</a>&nbsp;&bull;&nbsp;<a href="https://github.com/Bootflat/Bootflat.UI.Kit.PSD/archive/master.zip">Free PSD</a>&nbsp;&bull;&nbsp;<a href="colors.html">Color Picker</a></p>
          <p>Code licensed under <a href="http://opensource.org/licenses/mit-license.html" target="_blank" rel="external nofollow">MIT License</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/" rel="external nofollow">CC BY 3.0</a>.</p>
        </div>
      </div>
    </div>
  </body>
</html>
