<?php 
  $titulo = "Datos de Médico";
  include 'header.php'; 
   include 'core/conex.php'; 

  $aperm = $_SESSION['perm'];

  $med = $_GET['id'];

  if($usertype > 2){
    if(!array_key_exists(MOD_MEDICO, $aperm)){
      include '403.php';
      exit(0);
    }
    if(($usertype == 3 || $usertype == 4) && $med != $_SESSION['medico']){
      include '403.php';
      exit(0);
    }else{
      $perm = $aperm[MOD_MEDICO];
      $edita = false;
      if($perm['action'] == 'EDIT') $edita = true;
    }
  }else{
    if(!array_key_exists(MOD_MEDICOS, $aperm)){
      include '403.php';
      exit(0);
    }else{
      $perm = $aperm[MOD_MEDICOS];
      $edita = false;
      if($perm['action'] == 'EDIT') $edita = true;
    }
  }

  $ID = $med;

  $SQL = "SELECT CONCAT(nombre, ' ', paterno, ' ', materno) AS nomMed, sexo, nacionalidad, nacimiento_lugar, fotografia, nacimiento_fecha, 
                  num_cedula, num_recer, fecha_recer, giro, slogan, 
                  medios_digitales, servicios, archivos, 
                  /*IFNULL((SELECT ID FROM medico_especialidad WHERE id_medico = m.ID LIMIT 1),0) AS esp,*/ 
                  IFNULL((SELECT ID FROM medico_fiscal WHERE id_medico = m.ID LIMIT 1),0) AS fact 
              FROM medico m WHERE ID = $ID; ";
  $res = mysqli_query($conn,$SQL);
  $infoMed = mysqli_fetch_assoc($res);

  //$SQLme = "SELECT id_especialidad, especialidad, subespecialidad, num_cedula, num_recer, fecha_recer FROM medico_especialidad WHERE ID = ".$infoMed['esp'];
  //$infoEsp = mysql_fetch_assoc(mysql_query($SQLme));

  $SQLmf = "SELECT * FROM medico_fiscal WHERE ID = ".$infoMed['fact'];
  $infoFact = mysqli_fetch_assoc(mysqli_query($conn,$SQLmf));


  /*$SQLe = "SELECT ID, nombre FROM especialidades WHERE status = 1; ";
  $rese = mysql_query($SQLe);

  $arrEsp = array();
  while ($esp = mysql_fetch_assoc($rese)){
    $arrEsp[] = $esp;
  }

  $SQLse = "SELECT nombre FROM subespecialidades WHERE id_especialidad = ".$infoEsp['id_especialidad'];
  $resse = mysql_query($SQLse);*/


?>

    <!-- Datatables -->
    <link href="<?php echo URL_ROOT; ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_ROOT; ?>/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">

    <!-- page content -->
    <div class="right_col" role="main">

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Datos del Médico <strong><?= $infoMed['nomMed'] ?></strong></h2>
              <input type="hidden" id="med-id" value="<?= $med ?>">
              <div class="clearfix"></div>
            </div>
            <div class="x_content">


              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTabs" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active">
                    <a href="#general-tab" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#consultorios-tab" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Consultorios</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#contacto-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Medios de Contacto</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#profesional-tab" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Experiencia Profesional</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#curriculum-tab" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Curriculum</a>
                  </li>
                  <?php if($infoMed['medios_digitales'] == 1) : ?>
                  <li role="presentation">
                    <a href="#tab_cdig" role="tab" data-toggle="tab" aria-expanded="true">Medios Digitales</a>
                  </li>
                  <?php endif; ?>
                  <!--li role="presentation" class="">
                    <a href="#servicios-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Servicios</a>
                  </li-->
                  <?php if($infoMed['archivos'] == 1) : ?>
                  <li role="presentation" class="">
                    <a href="#archivos-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Archivos</a>
                  </li>
                  <?php endif; ?>
                  <li role="presentation" class="">
                    <a href="#facturacion-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Facturación</a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="general-tab" aria-labelledby="general-tab">
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-12">
                        <span class="section">Fotografía</span>

                        <?php 
                          $src = 'data-src="holder.js/100%x200/text:Imagen"';
                          if($infoMed['fotografia'] != '') $src = 'src="'.URL_ROOT.'/data/'.$infoMed['fotografia'].'"';
                        ?>

                        <img id="medico-foto" class="img-thumbnail" <?php echo $src; ?> alt="<?php echo $infoMed['nombre']; ?>">
                        <?php if($edita) : ?>
                        <br>
                        <button id="btnDelFoto" type="button" class="close <?php echo $infoMed['fotografia'] != '' ? '' : 'hide'; ?>" aria-hidden="true" data-toggle="tooltip" title="Quitar fotografia">&times;</button>
                        <div id="btnFoto" class="btn btn-default btn-sm">
                          <i class="fa fa-camera"></i> Cambiar Fotografia...
                        </div><br>
                        <!--div class="alert alert-info">Imagen <strong>JPG o PNG de hasta 1MB y 500x500px</strong></div-->
                        <div id="messages" class="alert"></div>
                        <?php endif; ?>
                      </div>

                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <span class="section">Datos del Médico</span>

                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-sexo">Sexo</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select id="gral-sexo" class="form-control">
                                <option value="MASCULINO" <?= $infoMed['sexo'] == 'MASCULINO' ? 'selected' : '' ?>>MASCULINO</option>
                                <option value="FEMENINO" <?= $infoMed['sexo'] == 'FEMENINO' ? 'selected' : '' ?>>FEMENINO</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-nac">Nacionalidad</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select name="gral-nac" id="gral-nac" class="form-control">
                                <option value="Mexicana" <?php echo $infoMed['nacionalidad'] == 'Mexicana' ? 'selected': '' ?>>Mexicana</option>
                                <option value="Extranjera" <?php echo $infoMed['nacionalidad'] == 'Extranjera' ? 'selected': '' ?>>Extranjera</option>
                              </select>
                              <!--input type="text" id="gral-nac" class="form-control col-md-7 col-xs-12" placeholder="Nacionalidad" value="<?= $infoMed['nacionalidad'] ?>"-->
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-lnac">Lugar Nacimiento</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="gral-lnac" class="form-control col-md-7 col-xs-12 <?php echo $infoMed['nacionalidad'] == 'Mexicana' ? 'hide': '' ?>" placeholder="Lugar Nacimiento" value="<?= $infoMed['nacimiento_lugar'] ?>">
                              <select name="gral-lnace" id="gral-lnace" class="form-control col-md-7 col-xs-12 <?php echo $infoMed['nacionalidad'] == 'Mexicana' ? '': 'hide' ?>">
                                <?php 
                                  $SQLedo = "SELECT d_estado FROM codigo_postal GROUP BY d_estado ORDER BY d_estado; ";
                                  $resedo = mysqli_query($conn,$SQLedo);
                                  while ($edo = mysqli_fetch_assoc($resedo)) {
                                    $sel = '';
                                    if($infoMed['nacimiento_lugar'] == utf8_encode($edo['d_estado'])) $sel = 'selected';
                                    echo '<option value="'.utf8_encode($edo['d_estado']).'" '.$sel.'>'.utf8_encode($edo['d_estado']).'</option>';
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-fnac">Fecha Nacimiento</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input type="text" class="form-control has-feedback-left datepicker" id="gral-fnac" placeholder="Fecha de Nacimiento" aria-describedby="inputSuccess2Status4" data-inputmask="'mask': '99/99/9999'" value="<?= $infoMed['nacimiento_fecha'] ?>">
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          </div>

                        </form>
                      </div>
                      
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <span class="section">Datos Profesionales</span>

                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-ced">Cédula Profesional</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="gral-ced" class="form-control col-md-7 col-xs-12" placeholder="Número Cédula Profesional" value="<?= $infoMed['num_cedula'] ?>" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-inst">Institución Egreso</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="gral-inst" class="form-control col-md-7 col-xs-12" placeholder="Institución de Egreso" value="<?= $infoMed['num_recer'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-fegre">Año Egreso</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input type="text" id="gral-fegre" class="form-control col-md-7 col-xs-12" placeholder="Año de Egreso" data-inputmask="'mask': '9999'" value="<?= $infoMed['fecha_recer'] ?>">
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-7 col-sm-7 col-xs-12">
                        <span class="section">Especialidad <small>/ Subespecialidad</small></span>

                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="espe-esps">Especialidad</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="espe-esps" class="form-control ac-esp" placeholder="Especialidad">
                              <input type="hidden" id="espe-esp" value="0">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="espe-subess">Subespecialidad</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="espe-subess" class="form-control ac-subesp" placeholder="Subespecialidad">
                              <input type="hidden" id="espe-subes" value="0">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="espe-nced">Número Cédula</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input type="text" id="espe-nced" class="form-control col-md-7 col-xs-12" placeholder="Número de Cédula">
                            </div>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="espe-cert">Núm Certificación</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input type="text" id="espe-cert" class="form-control col-md-7 col-xs-12" placeholder="Número de Certificación">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="espe-fvenc">Fecha Vencimiento</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input type="text" class="form-control has-feedback-left datepicker" id="espe-fvenc" placeholder="Fecha de Vencimiento" aria-describedby="inputSuccess2Status4" data-inputmask="'mask': '99/99/9999'">
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                              <button id="btnCancelMesp" type="button" class="btn btn-sm btn-default"><i class="fa fa-remove"></i></button>
                              <button id="btnSaveMesp" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div>

                        </form>

                        <table id="tbl-espe" class="table table-striped jambo_table">
                          <thead>
                            <th>Especialidad</th>
                            <th>Subspecialidad</th>
                            <th>Cédula</th>
                            <th>
                              <?php if($edita) : ?>
                              <button id="btnAddMesp" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Agregar</button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                            <tr class="nodata"><td colspan="4">Cargando..</td></tr>
                          </tbody>
                        </table>
                      </div>
                      
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <span class="section">Instituciones de Salud <small>inscritas</small></span>

                        <form class="form-horizontal form-label-left hide">

                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12 input-sm" for="inst-nom">Nombre</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="inst-nom" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Nombre de la Institución">
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                              <button id="btnSaveI" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div>

                        </form>

                        <table id="tbl-inst" class="table table-striped jambo_table">
                          <thead>
                            <th>Institución</th>
                            <th>
                              <?php if($edita) : ?>
                              <button id="btnAddI" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Agregar</button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                            <tr class="nodata"><td colspan="2">Cargando..</td></tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="actionBar">
                      <?php if($edita) : ?>
                      <button id="btnUpdGral" type="button" class="btn btn-primary hide"><i class="fa fa-check"></i> Guardar Datos Generales</button>
                      <?php endif; ?>
                      <button type="button" class="btn btn-default btnNext" data-next="1">Siguiente <i class="fa fa-angle-double-right"></i></button>
                    </div>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="consultorios-tab" aria-labelledby="consultorios-tab">
                    <?php include 'med/consultorios.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="contacto-tab" aria-labelledby="contacto-tab">
                    <?php include 'med/contactos.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="profesional-tab" aria-labelledby="profesional-tab">
                    <?php include 'med/profesional.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="curriculum-tab" aria-labelledby="curriculum-tab">
                    <?php include 'med/curriculum.php'; ?>
                  </div>

                  <?php if($infoMed['medios_digitales'] == 1) : ?>
                  <div role="tabpanel" class="tab-pane fade" id="tab_cdig" aria-labelledby="medios-tab">
                    <?php include 'med/digitales.php'; ?>
                  </div>
                  <?php endif; ?>

                  <!--div role="tabpanel" class="tab-pane fade" id="servicios-tab" aria-labelledby="servicios-tab">
                    <?php //include 'med/servicios.php'; ?>
                  </div-->

                  <?php if($infoMed['archivos'] == 1) : ?>
                  <div role="tabpanel" class="tab-pane fade" id="archivos-tab" aria-labelledby="archivos-tab">
                    <?php include 'med/archivos.php'; ?>
                  </div>
                  <?php endif; ?>

                  <div role="tabpanel" class="tab-pane fade" id="facturacion-tab" aria-labelledby="facturacion-tab">
                    <?php include 'med/facturacion.php'; ?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      
      </div>
    </div>
    <!-- /page content -->

    <?php include 'footer.php'; ?>
    <script src="/vendors/iCheck/icheck.min.js"></script>

    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-daterangepicker >
    <script src="js/moment/moment.min.js"></script-->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    <script src="/js/datepicker/daterangepicker.js"></script>
    <!-- jquery.inputmask -->
    <script src="/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

    <!-- Datatables -->
    <script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

    <script src="/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/holder.js"></script>
    <script src="/js/fineuploader-3.8.0.min.js"></script>

    <script src="/js/medico.js"></script>

    