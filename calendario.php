<?php 
  $titulo = "Calendario";
  include 'header.php'; 

  $aperm = $_SESSION['perm'];
  if(!array_key_exists(MOD_MEDICOS, $aperm)){
    include '403.php';
    exit(0);
  }else{
    $perm = $aperm[MOD_MEDICOS];
    $perm = $perm['action'];
  }

?>

    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">


    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <!-- Select2 >
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet"-->


    <!-- Custom Theme Style >
    <link href="build/css/custom.min.css" rel="stylesheet"-->



        <!-- page content -->
        <div class="right_col" role="main">


          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Alta de Grupo Médicos <small>Grupos registrados</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li><a id="btnAdd" class="add-link"><i class="fa fa-plus"></i> Agregar Grupo</a></li>
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                      <table id="tbl-items" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Nombre </th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Telefono</th>
                            <th>Giro</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
          </div>


          <?php if($perm == 'EDIT') : ?>
          <div id="frm-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Agregar </h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item-nom">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Grupo Médico">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-ape" class="control-label col-md-3 col-sm-3 col-xs-12">Responsable</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-ape" class="form-control col-md-7 col-xs-12" type="text" placeholder="Responsable">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-mat" class="control-label col-md-3 col-sm-3 col-xs-12">Giro</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-mat" class="form-control col-md-7 col-xs-12" type="text" placeholder="Giro">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="item-ced" class="control-label col-md-3 col-sm-3 col-xs-12">Celular <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="item-ced" class="form-control col-md-7 col-xs-12" type="text" placeholder="Celular" <?php echo $usertype != 1 ? 'disabled' : '' ?>>
                      </div>
                    </div>

                 
                    <div class="form-group">
                      <label for="item-sexo" class="control-label col-md-3 col-sm-3 col-xs-12">Estado <span class="required">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-sexo" class="form-control col-md-7 col-xs-12" type="text" placeholder="Estado">
                      </div>
                    </div>
                    
                    <hr class="creado">
                    <div class="form-group creado">
                      <label for="item-creado" class="control-label col-md-3 col-sm-3 col-xs-12">Creado</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-creado" class="form-control col-md-7 col-xs-12" type="text" readonly>
                      </div>
                    </div>
                    
                  </form>
                </div>
                <div class="modal-footer">
                  <input type="hidden" id="item-id" value="0">
                  <input type="hidden" id="item-med" value="0">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <a href="#" id="btnDatos" class="btn btn-default hide">Ver todos los datos</a>
                  <button id="btnSave" type="button" class="btn btn-primary">Guardar</button>
                </div>

              </div>
            </div>
          </div>


          <div class="modal fade" id="frm-item-del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">Eliminar Médico</h4>
                      </div>
                      <div class="modal-body">
                          <p>¿Estas seguro de eliminar a '<strong></strong>' (<strong></strong>)?</p>
                          <input type="hidden" id="item-del-id" value="0">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnDelete">Eliminar</button>
                      </div>
                  </div>
              </div>
          </div>
          <?php endif; ?>



          
        </div>
        <!-- /page content -->

        <?php include 'footer.php'; ?>


    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>

	<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
