
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <a class="navbar-brand" href="<?php echo URL_ROOT; ?>"><?php echo PAGE_TITLE; ?> <small><?php echo $_SESSION['mediconom'] ?></small></a>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <!--img src="images/img.jpg" alt=""-->
                    <i class="fa fa-user"></i>
                    <?php echo $username ?>
                    <i class=" fa fa-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <?php if($_SESSION['status'] != 3) : ?>
                    <li><a data-toggle="modal" href="#form-pass"><i class="fa fa-key pull-right"></i> Cambiar contraseña</a></li>
                    <?php endif; ?>
                    <li><a href="/core/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>