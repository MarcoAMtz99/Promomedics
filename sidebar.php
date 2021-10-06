      <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo URL_ROOT; ?>" class="site_title">
                <img class="logo-sm" src="<?php echo URL_ROOT; ?>/images/logo_small.png" alt="<?php echo PAGE_TITLE ?>">
                <img class="logo-md" src="<?php echo URL_ROOT; ?>/images/logo_small.png" alt="<?php echo PAGE_TITLE ?>">
              </a>
            </div>
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php  if(isset($username)){echo $username;} ?></h2>
              </div>

              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!--h3>General</h3-->
                <ul class="nav side-menu">

                  <?php  
                  if (isset($_SESSION['perm'])) {
                     $permArray = $_SESSION['perm'];
                  }
                   
                 if (isset( $permArray)) {
                      # code...
                    
                    foreach ($permArray as $perm) {
                      if(isset($perm['children'])){
                        echo '<li id="mnu-'.$perm['abrev'].'"><a><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].' <span class="fa fa-chevron-down"></span></a>';
                        echo '<ul class="nav child_menu">';

                        foreach ($perm['children'] as $mnu) {
                          echo '<li id="mnu-'.$mnu['abrev'].'"><a href="'.URL_ROOT.$mnu['url'].'">'.$mnu['nombre'].'</a></li>';
                        }

                        echo "</ul>";
                        echo "</li>";
                      }else{
                        if($perm['url'] == '/medico' && ($usertype == 3 || $usertype == 4)) $perm['url'] .= '/'.$_SESSION['medico'];

                        if($perm['url'] == '/gpomedico'){
                          if($perm['url'] == '/gpomedico' && ($usertype == 3 || $usertype == 4) && $_SESSION['grupo'] != 0){
                            $perm['url'] .= '/'.$_SESSION['grupo'];
                            echo '<li id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                          }
                        }else{
                          echo '<li id="mnu-'.$perm['abrev'].'"><a href="'.URL_ROOT.$perm['url'].'"><i class="fa fa-'.$perm['icono'].'"></i> '.$perm['nombre'].'</a></li>';
                        }
                      }
                    }
                  } //Fin del if para validar isset 
                    echo' <li id="mnu-cal"><a href="'.URL_ROOT.'/calendario.php"><i class="fa fa-calendar"></i> Agenda</a></li>';
                  ?>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->