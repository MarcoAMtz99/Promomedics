
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
                          <label for="fact-sexo" class="control-label col-md-3 col-sm-3 col-xs-12">GENERO</label>
                              <select class="form-control" id="fact-sexo">
                                <option value="1">MASCULINO</option>
                                <option value="2">FEMENINO</option>
                                <option value="3">OTRO</option>
                              </select>
                            </div>

                            <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">TUTOR(A)</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="TUTOR(A)" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>
                          <span class="section">DATOS DE CONTACTO</span>
                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">TELEFONO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="TELEFONO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">TELEFONO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="TELEFONO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">EMAIL</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="EMAIL" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">NOMBRE DEL MEDICO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="NOMBRE DEL MEDICO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">CONSULTORIO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="CONSULTORIO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">FOLIO DE RESERVACION</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="FOLIO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>
                          <span class="section">CONSULTA:</span>
                          <div class="col-md-5 col-sm-5 col-xs-12">
                          <label for="fact-sexo" class="control-label col-md-3 col-sm-3 col-xs-12">TIPO:</label>
                              <select class="form-control" id="fact-sexo">
                                <option value="1">PRIMERA VEZ</option>
                                <option value="2">SUBSECUENTE</option>
                                <option value="3">URGENCIA</option>
                                <option value="4">SIN COSTO</option>
                                <option value="5">1RA VEZ</option>
                              </select>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                          <label for="fact-ASE" class="control-label col-md-3 col-sm-3 col-xs-12">ASEGURADORA</label>
                              <select class="form-control" id="fact-ASE">
                                <option value="1">GNP</option>
                                <option value="2">SEGUROS MONTERREY</option>
                                <option value="3">SEGUROS INBURSA</option>
                              </select>
                            </div>
                          
                            <div class="col-md-5 col-sm-5 col-xs-12">
                          <label for="fact-ASE" class="control-label col-md-3 col-sm-3 col-xs-12">??COMO SE GENER?? LA CITA? </label>
                              <select class="form-control" id="fact-ASE">
                                <option value="1">CONSULTORIO</option>
                                <option value="2">TELEFONO</option>
                                <option value="3">MEDICO</option>
                              </select>
                            </div>
                            
                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">??QUIEN LA REALIZO?</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="PACIENTE" value="<?= $infoFact['representante'] ?>">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="USUARIO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>
                          <div class="form-group persmoral">
                            <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">RECADO</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="RECADO" value="<?= $infoFact['representante'] ?>">
                            </div>
                          </div>

                        </form>
                      </div>

                  
                    </div>
              

                    <div class="actionBar">
                      <?php if($edita) : ?>
                      <button type="button" class="btn btn-primary hide" id="btnSaveFact"><i class="fa fa-check"></i> AGENDAR CITA</button>
                      <?php endif; ?>
                      <button type="button" class="btn btn-default btnNext" data-next="<?php echo $ant ?>"><i class="fa fa-angle-double-left"></i> AGENDAR CITA</button>
                      <!--button type="button" class="btn btn-default btnNext" data-next="6">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                    </div>


                    
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
                  </div>
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