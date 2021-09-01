
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
                      <h2>AGENDA <small></small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                     <!--  <button onclick="getMedicos()">ACTUALIZAR</button> -->
                        <?php if($perm == 'EDIT') : ?>
                       <!--  <li><a id="btnAdd" class="add-link"><i class="fa fa-plus"></i> Agregar Cita</a></li> -->
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTabs" class="nav nav-tabs bar_tabs" role="tablist">
                 <!--  <li role="presentation" class="active">
                    <a href="#general-tab" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">DATOS MEDICOS</a>
                  </li> -->
                  <li role="presentation" class="">
                    <a href="#consultorios-tab" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">AGENDAR CITA</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#contacto-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Medios de Contacto</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#profesional-tab" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">CONFIRMACION</a>
                  </li>
                 <!--  <li role="presentation" class="">
                    <a href="#curriculum-tab" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">ALERTAS</a>
                  </li> -->
            
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="general-tab" aria-labelledby="general-tab">
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-12">


                




                    </div>
                  </div>
            </div>
          </div>
          <div class="row">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <span class="section">Datos Fiscales</span>

                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label for="fact-razon" class="control-label col-md-3 col-sm-3 col-xs-12">SELECCIONE LA FECHA</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="date" type="date">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="fact-rfc" class="control-label col-md-3 col-sm-3 col-xs-12">CONSULTA CON:</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="fact-rfc" required="required" class="form-control col-md-7 col-xs-12" placeholder="CONSULTA CON:" value="<?= $infoFact['rfc'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="fact-nom" class="control-label col-md-3 col-sm-3 col-xs-12">CONSULTORIO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-nom" class="form-control col-md-7 col-xs-12" type="text" placeholder="CONSULTORIO" value="<?= $infoFact['nombre_comercial'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="control-label col-md-3 col-sm-3 col-xs-12"></div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select class="form-control" id="fact-tipo">
                                <!-- <option value="1">Persona Física</option>
                                <option value="2">Persona Moral</option> -->
                              </select>
                            </div>
                          </div>
                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">NOMBRE</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="Nombre " value="<?= $infoFact['representante'] ?>">
                            </div>
                            <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">A PATERNO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="A PATERNO" value="<?= $infoFact['representante'] ?>">
                            </div>
                            <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">A MATERNO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="A MATERNO" value="<?= $infoFact['representante'] ?>">
                            </div>
                            <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">EDAD</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="EDAD" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="col-md-5 col-sm-5 col-xs-12">
                              <select class="form-control" id="fact-tipo">
                                <option value="1">MASCULINO</option>
                                <option value="2">FEMENINO</option>
                              </select>
                            </div>

                            <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">TUTOR(A)</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="TUTOR(A)" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                        </form>
                      </div>

                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <span class="section">DATOS DE CONTACTO</span>

                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fact-calle">TELEFONO 
                            </label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="fact-calle" required="required" class="form-control col-md-7 col-xs-12" placeholder="TELEFONO" value="<?= $infoFact['calle'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fact-calle">EMAIL 
                            </label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="fact-calle" required="required" class="form-control col-md-7 col-xs-12" placeholder="TELEFONO" value="<?= $infoFact['calle'] ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="fact-ext" class="control-label col-md-2 col-sm-2 col-xs-12">NOMBRE DEL MEDICO</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="fact-ext" class="form-control col-md-7 col-xs-12" type="text" placeholder="NOMBRE DEL MEDICO" value="<?= $infoFact['exterior'] ?>">
                            </div>
                            <label for="fact-int" class="control-label col-md-1 col-sm-1 col-xs-12">CONSULTORIO</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="fact-int" class="form-control col-md-7 col-xs-12" type="text" placeholder="CONSULTORIO" value="<?= $infoFact['interior'] ?>">
                            </div>
                            <label for="fact-cp" class="control-label col-md-1 col-sm-1 col-xs-12">FOLIO DE RESERVACION</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="fact-cp" class="form-control col-md-7 col-xs-12" type="text" data-inputmask="'mask' : '99999'" placeholder="FOLIO" value="<?= $infoFact['codigo_postal'] ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="fact-col" class="control-label col-md-2 col-sm-2 col-xs-12">Colonia</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select id="fact-col" class="select2_single form-control" tabindex="-1" style="width: 100%">
                                <?php 
                                  if(intval($infoMed['fact'])){
                                    echo '<option value="'.$infoFact['colonia'].'">'.$infoFact['colonia'].'</option>';
                                  }
                                ?>
                              </select>
                            </div>
                            <label for="fact-mun" class="control-label col-md-1 col-sm-1 col-xs-12">Municipio</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input id="fact-mun" class="form-control col-md-7 col-xs-12" type="text" placeholder="Delegación / Municipio" value="<?= $infoFact['municipio'] ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="fact-ciu" class="control-label col-md-2 col-sm-2 col-xs-12">Ciudad</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input id="fact-ciu" class="form-control col-md-7 col-xs-12" type="text" placeholder="Ciudad" value="<?= $infoFact['ciudad'] ?>">
                            </div>
                            <label for="fact-edo" class="control-label col-md-1 col-sm-1 col-xs-12">Estado</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input id="fact-edo" class="form-control col-md-7 col-xs-12" type="text" placeholder="Estado" value="<?= $infoFact['estado'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fact-mail">Email</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input type="text" id="fact-mail" class="form-control col-md-7 col-xs-12" placeholder="Correo electrónico" value="<?= $infoFact['email'] ?>">
                            </div>
                          </div>

                        </form>
                        <input type="hidden" id="fact-id" value="<?= $infoMed['fact'] ?>">
                      </div>
                    </div>

                    <div class="actionBar">
                      <?php if($edita) : ?>
                      <button type="button" class="btn btn-primary hide" id="btnSaveFact"><i class="fa fa-check"></i> AGENDAR CITA</button>
                      <?php endif; ?>
                      <button type="button" class="btn btn-default btnNext" data-next="<?php echo $ant ?>"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <!--button type="button" class="btn btn-default btnNext" data-next="6">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                    </div>


                    <!-- 
        
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



          
        </div>
        <!-- /page content -->
        <div role="tabpanel" class="tab-pane fade" id="consultorios-tab" aria-labelledby="consultorios-tab">
                    <?php include 'calendario/datos.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="contacto-tab" aria-labelledby="contacto-tab">
                    <?php include 'med/agendar.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="profesional-tab" aria-labelledby="profesional-tab">
                    <?php include 'med/medios.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="curriculum-tab" aria-labelledby="curriculum-tab">
                    <?php include 'med/confirmacion.php'; ?>
                  </div>


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

    
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>


    <script>
      $(document).ready(function() {

        $.get('core/agenda/getMedicos');
      function getMedicos(){
        NProgress.start();
        $.post('core/agenda/getMedicos', 
          {}, 
          function(resp) {
            $('#tbl-items tbody').empty();
            console.log('datos grupo medico',resp.item);
            //  $.each(resp, function(index){
                addItemRow( resp.item,0);
             // });
              $("[data-toggle='tooltip']").tooltip();
            
            doTable('#tbl-items', 5);
            NProgress.done();
        },'json');
      }
    });
     

    </script>