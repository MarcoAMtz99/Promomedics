
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <a href="<?php echo URL_ROOT ?>" title="<?php echo PAGE_TITLE ?>"><?php echo PAGE_TITLE ?></a> © <?php echo date('Y'); ?> Todos los derechos reservados.
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
        
        <?php

        if (isset($_SESSION['status'])) {
          if($_SESSION['status'] != 3) {


          ?>
        <div id="form-pass" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Cambiar Contraseña</h4>
                </div>
                <div class="modal-body">
                  <div class="form-horizontal">
                    <div class="form-group">
                      <label for="pass-act" class="col-lg-4 control-label">Contraseña Actual</label>
                      <div class="col-lg-8">
                        <input type="password" class="form-control" id="pass-act" placeholder="Contraseña Actual">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="pass-new" class="col-lg-4 control-label">Nueva Contraseña</label>
                      <div class="col-lg-8">
                        <input type="password" class="form-control" id="pass-new" placeholder="Nueva Contraseña">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="pass-new2" class="col-lg-4 control-label">Repetir Contraseña</label>
                      <div class="col-lg-8">
                        <input type="password" class="form-control" id="pass-new2" placeholder="Nueva Contraseña">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-primary" id="btnSavePass">Cambiar</button>
                </div>
              </div>
            </div>
        </div>
        <?php
            }
        } ?>
        
      </div>
    </div>
  </body>
</html>
    <!-- jQuery -->
    <script src="<?php echo URL_ROOT; ?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo URL_ROOT; ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>/js/jquery.json-2.4.min.js"></script>
    <script src="<?php echo URL_ROOT; ?>/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/main.js"></script>