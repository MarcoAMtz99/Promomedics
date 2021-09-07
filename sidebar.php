      <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo URL_ROOT; ?>" class="site_title">
                <img class="logo-sm" src="/images/logo_small.png" alt="<?php echo PAGE_TITLE ?>">
                <img class="logo-md" src="/images/logo_small.png" alt="<?php echo PAGE_TITLE ?>">
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $username ?></h2>
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
                    $permArray = $_SESSION['perm'];

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
                    <li id="mnu-cal"><a href="https://promomedics.byw-si.com.mx/calendario.php"><i class="fa fa-calendar"></i> Agenda</a></li>
                  ?>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->