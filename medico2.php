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

  $SQL = "SELECT CONCAT(nombre, ' ', paterno, ' ', materno) AS nomMed, sexo, nacionalidad, nacimiento_lugar, nacimiento_fecha, num_cedula, num_recer, fecha_recer, IFNULL((SELECT ID FROM medico_especialidad WHERE id_medico = m.ID LIMIT 1),0) AS esp, IFNULL((SELECT ID FROM medico_fiscal WHERE id_medico = m.ID LIMIT 1),0) AS fact FROM medico m WHERE ID = $ID; ";
  $res = mysqli_query($SQL);
  $infoMed = mysqli_fetch_assoc($conn,$res);

  $SQLme = "SELECT id_especialidad, especialidad, subespecialidad, num_cedula, num_recer, fecha_recer FROM medico_especialidad WHERE ID = ".$infoMed['esp'];
  $infoEsp = mysqli_fetch_assoc(mysql_query($conn,$SQLme));

  $SQLmf = "SELECT * FROM medico_fiscal WHERE ID = ".$infoMed['fact'];
  $infoFact = mysqli_fetch_assoc(mysql_query($conn,$SQLmf));


  $SQLe = "SELECT ID, nombre FROM especialidades WHERE status = 1; ";
  $rese = mysqli_query($conn,$SQLe);

  $SQLse = "SELECT nombre FROM subespecialidades WHERE id_especialidad = ".$infoEsp['id_especialidad'];
  $resse = mysqli_query($conn,$SQLse);


?>



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
                        <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Consultorios</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Medios de Contacto</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Experiencia Profesional</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Curriculum</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content6" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Facturación</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content7" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Servicios</a>
                      </li>
                      <li role="presentation" class="">
                        <a href="#tab_content8" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Archivos</a>
                      </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="general-tab">                       
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
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
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="gral-nac" class="form-control col-md-7 col-xs-12" placeholder="Nacionalidad" value="<?= $infoMed['nacionalidad'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-lnac">Lugar Nacimiento</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="gral-lnac" class="form-control col-md-7 col-xs-12" placeholder="Lugar Nacimiento" value="<?= $infoMed['nacimiento_lugar'] ?>">
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
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
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
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Especialidad <small>/ Subespecialidad</small></span>

                            <form class="form-horizontal form-label-left">
                              <input type="hidden" id="gral-idesp" value="<?= $infoMed['esp']; ?>">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-esp">Especialidad</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <select id="gral-esp" class="form-control">
                                    <?php  
                                      while ($esp = mysql_fetch_assoc($rese)) {
                                        $esp['nombre'] = utf8_encode($esp['nombre']);
                                        $sel = $esp['ID'] == $infoEsp['id_especialidad'] ? 'selected' : '';
                                        echo '<option value="'.$esp['ID'].'" '.$sel.'>'.$esp['nombre'].'</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-subes">Subespecialidad</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <select id="gral-subes" class="form-control">
                                    <?php  
                                      while ($sub = mysql_fetch_assoc($resse)) {
                                        $sub['nombre'] = utf8_encode($sub['nombre']);
                                        $sel = $sub['nombre'] == $infoEsp['subespecialidad'] ? 'selected' : '';
                                        echo '<option value="'.$sub['nombre'].'" '.$sel.'>'.$sub['nombre'].'</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-nced">Número Cédula</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="gral-nced" class="form-control col-md-7 col-xs-12" placeholder="Número de Cédula" value="<?= $infoEsp['num_cedula'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-cert">Núm Certificación</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="gral-cert" class="form-control col-md-7 col-xs-12" placeholder="Número de Certificación" value="<?= $infoEsp['num_recer'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gral-fvenc">Fecha Vencimiento</label>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                  <input type="text" class="form-control has-feedback-left datepicker" id="gral-fvenc" placeholder="Fecha de Vencimiento" aria-describedby="inputSuccess2Status4" data-inputmask="'mask': '99/99/9999'" value="<?= $infoEsp['fecha_recer'] ?>">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>

                            </form>
                          </div>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Instituciones de Salud <small>donde atiende el médico</small></span>

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
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="actionBar">
                          <?php if($edita) : ?>
                          <button id="btnUpdGral" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Guardar Datos Generales</button>
                          <?php endif; ?>
                          <button type="button" class="btn btn-default btnNext" data-next="1">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="consultorios-tab">
                        <div class="row">
                          <div id="cons-tbl" class="col-md-12 col-sm-12 col-xs-12">
                            <table id="tbl-cons" class="table table-striped jambo_table">
                              <thead>
                                <th>Nombre del Consultorio</th>
                                <th>Primer Consulta</th>
                                <th>Subsecuente</th>
                                <th>Preferente</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddCons" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Agregar</button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          <div id="cons-info" class="col-md-4 col-sm-4 col-xs-12 hide">
                            <span class="section">Datos del Consultorio</span>

                            <form class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cons-nom">Nombre</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                  <input type="text" id="cons-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Consultorio">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="cons-prim">Consulta Primera Vez</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                  <input type="text" id="cons-prim" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Costo">
                                  <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="cons-sub">Consulta Subsecuente</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                  <input type="text" id="cons-sub" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Costo">
                                  <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="cons-pref">Consulta Preferente</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                  <input type="text" id="cons-pref" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Costo">
                                  <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="col-md-7 col-sm-7 col-xs-12"></div>
                                <div class="col-md-5 col-sm-5 col-xs-12 text-right">
                                  <input type="hidden" id="cons-id" value="0">
                                  <button id="btnSaveCons" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Guardar Datos</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        

                        <div id="datos-cons" class="row hide">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="section">Datos del Consultorio</span>

                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="consTabs" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active">
                                  <a href="#tab_cgral" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                                </li>
                                <li role="presentation">
                                  <a href="#tab_chor" role="tab" data-toggle="tab" aria-expanded="true">Horarios Atención</a>
                                </li>
                                <li role="presentation">
                                  <a href="#tab_ccub" role="tab" data-toggle="tab" aria-expanded="true">Cubículos</a>
                                </li>
                                <li role="presentation">
                                  <a href="#tab_cdig" role="tab" data-toggle="tab" aria-expanded="true">Medios Digitales</a>
                                </li>
                                <li role="presentation">
                                  <a href="#tab_cstaff" role="tab" data-toggle="tab" aria-expanded="true">Staff Médico</a>
                                </li>
                              </ul>

                              <div id="consTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_cgral" aria-labelledby="consgral-tab">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <span class="section">Convenios</span>

                                      <?php if($edita) : ?>
                                      <form class="form-horizontal form-label-left hide">
                                        <div class="form-group">
                                          <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="conv-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Empresa de Convenio">
                                          </div>
                                          <div class="col-md-2 col-sm-2 col-xs-12">
                                            <input type="text" id="conv-costo" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Costo">
                                            <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                            <button id="btnSaveConv" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                          </div>
                                        </div>
                                      </form>
                                      <?php endif; ?>

                                      <table id="tbl-conv" class="table table-striped jambo_table">
                                        <thead>
                                          <th>Empresa Convenio</th>
                                          <th>Costo Consulta</th>
                                          <th>
                                            <?php if($edita) : ?>
                                            <button id="btnAddConv" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                            <?php endif; ?>
                                          </th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <span class="section">Aseguradoras</span>

                                      <?php if($edita) : ?>
                                      <form class="form-horizontal form-label-left hide">
                                        <div class="form-group">
                                          <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" id="ase-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Aseguradora">
                                          </div>
                                          <div class="col-md-2 col-sm-2 col-xs-12">
                                            <input type="text" id="ase-costo" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Costo">
                                            <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                            <button id="btnSaveAse" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                          </div>
                                        </div>
                                      </form>
                                      <?php endif; ?>

                                      <table id="tbl-ase" class="table table-striped jambo_table">
                                        <thead>
                                          <th>Aseguradora</th>
                                          <th>Costo Consulta</th>
                                          <th>
                                            <?php if($edita) : ?>
                                            <button id="btnAddAse" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                            <?php endif; ?>
                                          </th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>

                                  <div class="actionBar">                          
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="1">Siguiente <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_chor" aria-labelledby="consgral-tab">
                                  <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                      <span class="section">Horarios de atención</span>

                                      <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-4 col-sm-4 col-xs-12" for="horac-lini">Tiempo estimado</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select class="form-control" id="hora-tiem">
                                              <option value="15">15 min</option>
                                              <option value="20">20 min</option>
                                              <option value="30">30 min</option>
                                              <option value="45">45 min</option>
                                              <option value="60">60 min</option>
                                              <option value="90">90 min</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-4 col-sm-4 col-xs-12" for="horac-lini">Hora Comida</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="hora-cini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="hora-cfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>

                                      </form>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                      <span class="section">Horarios de Consulta</span>

                                      <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Lunes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-lini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-lfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Martes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-mini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-mfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Miércoles</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-miini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-mifin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Jueves</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-jini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-jfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Viernes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-vini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-vfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Sábado</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-sini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-sfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horac-lini">Domingo</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-dini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horac-dfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                      </form>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                      <span class="section">Horarios Quirúrgicos</span>

                                      <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Lunes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-lini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-lfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Martes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-mini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-mfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Miércoles</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-miini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-mifin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Jueves</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-jini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-jfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Viernes</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horav-lini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horav-lfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Sábado</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-sini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-sfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horaq-lini">Domingo</label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-dini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="horaq-dfin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                            <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>


                                  <div class="actionBar">                          
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                    <button id="btnSaveHor" type="button" class="btn btn-sm btn-round btn-primary"><i class="fa fa-check"></i> Guardar Horarios</button>
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_ccub" aria-labelledby="consgral-tab">
                                  <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                      <span class="section">Cubículo</span>
                                      <table id="tbl-cub" class="table table-striped jambo_table">
                                        <thead>
                                          <th>Nombre</th>
                                          <th>Médico Apoyo</th>
                                          <th>Características</th>
                                          <th>
                                            <?php if($edita) : ?>
                                            <button id="btnAddCub" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Agregar</button>
                                            <?php endif; ?>
                                          </th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 ">
                                      <span class="section">Datos del Cubículo</span>

                                      <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                          <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cub-nom">Nombre</label>
                                          <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" id="cub-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Consultorio">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cub-med">Médico Apoyo</label>
                                          <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" id="cub-med" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico de Apoyo">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cub-car">Características</label>
                                          <div class="col-md-10 col-sm-10 col-xs-12">
                                            <textarea class="form-control" id="cub-car" rows="2" placeholder="Características"></textarea>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <div class="col-md-7 col-sm-7 col-xs-12"></div>
                                          <div class="col-md-5 col-sm-5 col-xs-12">
                                            <?php if($edita) : ?>
                                            <button id="btnSaveCub" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Guardar</button>
                                            <?php endif; ?>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>

                                  <div class="actionBar">                          
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="1"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="3">Siguiente <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_cdig" aria-labelledby="consgral-tab">

                                  <div class="actionBar">                          
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="2"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="4">Siguiente <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_cstaff" aria-labelledby="consgral-tab">

                                  <div class="actionBar">                          
                                    <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="3"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          
                          </div>
                        </div>

                        <div class="actionBar">                          
                          <button type="button" class="btn btn-default btnNext" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <button type="button" class="btn btn-default btnNext" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="contacto-tab">
                        <div class="row">
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <span class="section">Contactos registrados</span>

                            <table id="tbl-cont" class="table table-striped jambo_table">
                              <thead>
                                <th>Nombre</th>
                                <th>Area</th>
                                <th>Puesto</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddC" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Agregar</button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>

                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <span class="section">Contacto</span>
                            <form class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-nom">Nombre</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cont-nom" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Nombre del Contacto">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-pat">Paterno</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cont-pat" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Apellido Paterno">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-mat">Materno</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cont-mat" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Apellido Materno">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-area">Area</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cont-area" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Area">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-pues">Puesto</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cont-pues" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Puesto">
                                </div>
                              </div>
                              
                              <?php if($edita) : ?>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" ></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <button id="btnSaveC" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Guardar</button>
                                </div>
                              </div>
                              <?php endif; ?>
                            </form>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <span class="section">Celular</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                  <input type="text" id="cel-num" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Celular" data-inputmask="'mask' : '(999) 999-9999'">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                  <button id="btnSaveCel" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-cel" class="table table-striped jambo_table">
                              <thead>
                                <th>Número</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddCel" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>

                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <span class="section">Teléfono</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                  <input type="text" id="tel-num" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Teléfono" data-inputmask="'mask' : '(999) 999-9999'">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                  <input type="text" id="tel-ext" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Extensión">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                  <button id="btnSaveTel" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-tel" class="table table-striped jambo_table">
                              <thead>
                                  <th>Número</th>
                                  <th>Ext</th>
                                  <th>
                                    <?php if($edita) : ?>
                                    <button id="btnAddTel" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                    <?php endif; ?>
                                  </th>
                                </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>

                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <span class="section">Email</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                  <input type="text" id="mail-mail" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Email">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <button id="btnSaveM" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-mail" class="table table-striped jambo_table">
                              <thead>
                                <th>Email</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddM" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2 col-sm-2 col-xs-12"></div>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <span class="section">Página Web</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                  <input type="text" id="pag-nom" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Nombre de la Página">
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                  <input type="text" id="pag-dir" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Dirección">
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button id="btnSavePag" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-pag" class="table table-striped jambo_table">
                              <thead>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddPag" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="actionBar">
                          
                          <button type="button" class="btn btn-default btnNext" data-next="1"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <button type="button" class="btn btn-default btnNext" data-next="3">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profesional-tab">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Idiomas</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                  <select class="form-control has-feedback-left" id="idi-idi">
                                    <option value="Español">Español</option>
                                    <option value="Inglés">Inglés</option>
                                    <option value="Francés">Francés</option>
                                    <option value="Alemán">Alemán</option>
                                  </select>
                                  <span class="fa fa-language form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" id="idi-hab" class="form-control has-feedback-left col-md-7 col-xs-12" placeholder="Hablado">
                                  <span class="fa fa-comments-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" id="idi-esc" class="form-control has-feedback-left col-md-7 col-xs-12" placeholder="Escrito">
                                  <span class="fa fa-pencil-square-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button id="btnSaveIdi" type="button" class="btn btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-idi" class="table table-striped jambo_table">
                              <thead>
                                <th>Idioma</th>
                                <th>%Hablado</th>
                                <th>% Escrito</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddIdi" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Experiencia Clínica</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-11 col-sm-11 col-xs-12">
                                  <textarea class="form-control input-sm" id="expc-desc" rows="2" placeholder="Descripción"></textarea>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                  <button id="btnSaveEC" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-expc" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripicón</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddEC" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Experiencia Quirúrgica</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-11 col-sm-11 col-xs-12">
                                  <textarea class="form-control input-sm" id="expq-desc" rows="2" placeholder="Descripción"></textarea>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                  <button id="btnSaveEQ" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-expq" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripicón</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddEQ" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Estudios, Tratamientos y Procesos Quirúrgicos Especializados</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-11 col-sm-11 col-xs-12">
                                  <textarea class="form-control input-sm" id="expt-desc" rows="2" placeholder="Descripción"></textarea>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                  <button id="btnSaveET" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-expt" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripicón</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button id="btnAddET" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="actionBar">
                          
                          <button type="button" class="btn btn-default btnNext" data-next="2"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <button type="button" class="btn btn-default btnNext" data-next="4">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="curriculum-tab">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Universidades</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="uni-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input type="text" id="uni-anio" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Año">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button data-tipo="uni" type="button" class="btn btn-sm btn-primary btnSaveCurr"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-uni" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button data-tipo="uni" type="button" class="btn btn-xs btn-default btnAddCurr"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Certificado por el consejo de</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cert-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input type="text" id="cert-anio" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Año">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button data-tipo="cert" type="button" class="btn btn-sm btn-primary btnSaveCurr"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-cert" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button data-tipo="cert" type="button" class="btn btn-xs btn-default btnAddCurr"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Miembro de Consejo <small>/ Asociaciones Internacionales</small></span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="con-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input type="text" id="con-anio" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Año">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button data-tipo="con" type="button" class="btn btn-sm btn-primary btnSaveCurr"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-con" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button data-tipo="con" type="button" class="btn btn-xs btn-default btnAddCurr"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Cursos y Simposiums</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="cur-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input type="text" id="cur-anio" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Año">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button data-tipo="cur" type="button" class="btn btn-sm btn-primary btnSaveCurr"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-cur" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button data-tipo="cur" type="button" class="btn btn-xs btn-default btnAddCurr"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="section">Datos Especiales</span>

                            <?php if($edita) : ?>
                            <form class="form-horizontal form-label-left hide">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="esp-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input type="text" id="esp-anio" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm" placeholder="Año">
                                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                                  <button data-tipo="esp" type="button" class="btn btn-sm btn-primary btnSaveCurr"><i class="fa fa-check"></i></button>
                                </div>
                              </div>
                            </form>
                            <?php endif; ?>

                            <table id="tbl-esp" class="table table-striped jambo_table">
                              <thead>
                                <th>Descripción</th>
                                <th>Año</th>
                                <th>
                                  <?php if($edita) : ?>
                                  <button data-tipo="esp" type="button" class="btn btn-xs btn-default btnAddCurr"><i class="fa fa-plus"></i></button>
                                  <?php endif; ?>
                                </th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="actionBar">
                          
                          <button type="button" class="btn btn-default btnNext" data-next="3"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <button type="button" class="btn btn-default btnNext" data-next="5">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="facturacion-tab">
                        <div class="row">
                          <div class="col-md-5 col-sm-12 col-xs-12">
                            <span class="section">Datos Fiscales</span>

                            <form class="form-horizontal form-label-left">

                              <div class="form-group">
                                <label for="fact-razon" class="control-label col-md-3 col-sm-3 col-xs-12">Razón Social</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="fact-razon" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre o Razón Social" value="<?= $infoFact['razon_social'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="control-label col-md-3 col-sm-3 col-xs-12"></div>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                  <select class="form-control" id="fact-tipo">
                                    <option value="1">Persona Física</option>
                                    <option value="2">Persona Moral</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="fact-rfc" class="control-label col-md-3 col-sm-3 col-xs-12">RFC</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="fact-rfc" required="required" class="form-control col-md-7 col-xs-12" placeholder="Registro Federal de Contribuyentes" value="<?= $infoFact['rfc'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="fact-nom" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Comercial</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="fact-nom" class="form-control col-md-7 col-xs-12" type="text" placeholder="Nombre Comercial" value="<?= $infoFact['nombre_comercial'] ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="fact-rep" class="control-label col-md-3 col-sm-3 col-xs-12">Representante Legal</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="fact-rep" class="form-control col-md-7 col-xs-12" type="text" placeholder="Nombre del Representante Legal" value="<?= $infoFact['representante'] ?>">
                                </div>
                              </div>

                            </form>
                          </div>

                          <div class="col-md-7 col-sm-12 col-xs-12">
                            <span class="section">Dirección Fiscal</span>

                            <form class="form-horizontal form-label-left">

                              <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fact-calle">Calle 
                                </label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                  <input type="text" id="fact-calle" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre de la calle" value="<?= $infoFact['calle'] ?>">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="fact-ext" class="control-label col-md-2 col-sm-2 col-xs-12">No. Ext.</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input id="fact-ext" class="form-control col-md-7 col-xs-12" type="text" placeholder="Número Exterior" value="<?= $infoFact['exterior'] ?>">
                                </div>
                                <label for="fact-int" class="control-label col-md-1 col-sm-1 col-xs-12">No. Int.</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input id="fact-int" class="form-control col-md-7 col-xs-12" type="text" placeholder="Número Interior" value="<?= $infoFact['interior'] ?>">
                                </div>
                                <label for="fact-cp" class="control-label col-md-1 col-sm-1 col-xs-12">C. P.</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                  <input id="fact-cp" class="form-control col-md-7 col-xs-12" type="text" data-inputmask="'mask' : '99999'" placeholder="Código Postal" value="<?= $infoFact['codigo_postal'] ?>">
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

                            </form>
                            <input type="hidden" id="fact-id" value="<?= $infoMed['fact'] ?>">
                          </div>

                        </div>

                        <div class="actionBar">
                          <button type="button" class="btn btn-default btnNext" data-next="4"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <?php if($edita) : ?>
                          <button type="button" class="btn btn-primary" id="btnSaveFact"><i class="fa fa-check"></i> Guardar Datos Fiscales</button>
                          <?php endif; ?>
                          <button type="button" class="btn btn-default btnNext" data-next="6">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content7" aria-labelledby="servicios-tab">
                        <p>Servicios.. Coming soon..</p>

                        <div class="actionBar">
                          <button type="button" class="btn btn-default btnNext" data-next="5"><i class="fa fa-angle-double-left"></i> Anterior</button>
                          <button type="button" class="btn btn-default btnNext" data-next="7">Siguiente <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="tab_content8" aria-labelledby="archivos-tab">
                        <p>Archivos.. Coming soon..</p>

                        <div class="actionBar">
                          
                          <button type="button" class="btn btn-default btnNext" data-next="6"><i class="fa fa-angle-double-left"></i> Anterior</button>
                        </div>
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



    
    

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>

    <script>
      $(document).ready(function() {

        $('#mnu-med').addClass('active');
        $('#mnu-info').addClass('active');

        $(":input").inputmask();

        moment.locale('es');
        $('.datepicker').daterangepicker({
          singleDatePicker: true,
          format: "DD/MM/YYYY",
          calender_style: "picker_4"
        });

        $med = $('#med-id').val();
        getInst($med);

        $('#gral-esp').change(function() {
          $('#gral-subes').addClass('disabled');
          NProgress.start();
          $.post('/core/medicos.php', 
            {action: 'getSubespecialidad', esp: $('#gral-esp').val()}, 
            function(resp) {
              $('#gral-subes').empty();
              $.each(resp, function(index, item) {
                $('#gral-subes').append('<option value="'+item.nombre+'">'+item.nombre+'</option>');
              });
              $('#gral-subes').removeClass('disabled');
              NProgress.done();
          },'json');
        });

        $('form').submit(function(event) {
          event.preventDefault();
        });

        $('.btnNext').click(function() {
          $('html, body').animate({
              scrollTop: 0//$("#med-id").offset().top
          }, 500);
          next = $(this).data('next');
          $('#myTabs li:eq('+next+') a').tab('show');
        });

        $('#btnUpdGral').click(function() {
          $('.alert').remove();
          $('.tooltip-error').remove();
          data = { med: $('#med-id').val(), 
                   esps: $("#gral-esp option:selected" ).text() }

          //$.each($("input[type=text] [id*=gral-]"), function(index, el) {
          $.each($("[id*=gral-]"), function(index, el) {
            id = $(el).attr('id');
            id = id.replace('gral-', '');

            data[id] = $.trim($(el).val());
          });

          btn = $(this);
          btn.addClass('disabled');
          NProgress.start();

          $.post('/core/medicos.php', 
            {action: 'saveGral', data: $.toJSON(data)}, 
            function(resp) {
              if(resp.success){
                $('#gral-idesp').val(resp.idesp);
                al = $('<div class="alert alert-success alert-dismissible fade in">Se guardaron los datos correctamente</div>');
                $('#tbl-inst').after(al);
                setTimeout(function(){ al.remove(); }, 7000);
              }else{
                setError('btnUpdGral', 'Ha ocurrido un error al guardar')
              }
              btn.removeClass('disabled');
              NProgress.done();
          },'json');
        });

        /** INSTITUCIONES **/
          $('#btnAddI').click(function() {
            $('#inst-nom').parents('form').removeClass('hide');
            $('#tbl-inst .info').removeClass('info');
            $('#inst-nom').val('').focus();
          });

          $('body').on('click', '.btne-edit', function(){
            $('#tbl-inst .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            nom = tr.find('td:eq(0)').text();

            $('#inst-nom').parents('form').removeClass('hide');
            $('#inst-nom').val(nom).focus();
          });

          $('#inst-nom').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveI').trigger('click'); } });

          $('#btnSaveI').click(function() {
            nom = $.trim($('#inst-nom').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-inst .info').length > 0) id = $('#tbl-inst .info').data('id');

            if(nom.length < 4){
              setError('inst-nom', 'Debe ingresar el nombre');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addInstitucion';
              if(parseInt(id,10) > 0) act = 'editInstitucion';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, nom: nom}, 
                function(resp) {
                  if(!resp.error){
                    addInstRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-inst .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveI', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btne-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            nom = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delInstitucion', nom: nom, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** CONTACTOS **/
          $('#btnAddC').click(function() {
            frm = $('#cont-nom').parents('form');
            $('#tbl-cont .info').removeClass('info');
            $(frm).find('input').val('');
            $('#cont-nom').focus();
          });

          $('body').on('click', '.btnc-edit', function(){
            $('#tbl-inst .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            nom = tr.find('td:eq(0) span:eq(0)').text();
            pat = tr.find('td:eq(0) span:eq(1)').text();
            mat = tr.find('td:eq(0) span:eq(2)').text();
            area = tr.find('td:eq(1)').text();
            pues = tr.find('td:eq(2)').text();

            $('#cont-nom').val(nom).focus();
            $('#cont-pat').val(pat);
            $('#cont-mat').val(mat);
            $('#cont-area').val(area);
            $('#cont-pues').val(pues);
          });

          $('#btnSaveC').click(function() {
            data = {med: $('#med-id').val(), nom: $.trim($('#cont-nom').val()), pat: $.trim($('#cont-pat').val()), mat: $.trim($('#cont-mat').val()), area: $.trim($('#cont-area').val()), pues: $.trim($('#cont-pues').val())}

            id = 0;
            if($('#tbl-cont .info').length > 0) id = $('#tbl-cont .info').data('id');
            data.id = id;

            if(data.nom.length < 4){
              setError('cont-nom', 'Debe ingresar el nombre');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              //frm = btn.parents('form');

              act = 'addContacto';
              if(parseInt(id,10) > 0) act = 'editContacto';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, data: $.toJSON(data)}, 
                function(resp) {
                  if(!resp.error){
                    addContRow(resp.item, resp.act);
                    //frm.addClass('hide');
                    //$('#tbl-cont .info').removeClass('info');
                    btn.removeClass('disabled');

                    frm = $('#cont-nom').parents('form');
                    $('#tbl-cont .info').removeClass('info');
                    $(frm).find('input').val('');
                  }else{
                    setError('btnSaveC', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btnc-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            nom = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delContacto', nom: nom, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** CELULARES **/
          $('#btnAddCel').click(function() {
            $('#cel-num').parents('form').removeClass('hide');
            $('#tbl-cel .info').removeClass('info');
            $('#cel-num').val('').focus();
          });

          $('body').on('click', '.btncel-edit', function(){
            $('#tbl-cel .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            num = tr.find('td:eq(0)').text();

            $('#cel-num').parents('form').removeClass('hide');
            $('#cel-num').val(num).focus();
          });

          $('#cel-num').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveCel').trigger('click'); } });

          $('#btnSaveCel').click(function() {
            num = $.trim($('#cel-num').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-cel .info').length > 0) id = $('#tbl-cel .info').data('id');

            if(num.length < 4){
              setError('cel-num', 'Debe ingresar el número');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addCelular';
              if(parseInt(id,10) > 0) act = 'editCelular';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, num: num}, 
                function(resp) {
                  if(!resp.error){
                    addCelRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-cel .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveCel', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btncel-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            num = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delCelular', num: num, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** TELEFONOS **/
          $('#btnAddTel').click(function() {
            $('#tel-num').parents('form').removeClass('hide');
            $('#tbl-tel .info').removeClass('info');
            $('#tel-ext').val('');
            $('#tel-num').val('').focus();
          });

          $('body').on('click', '.btnt-edit', function(){
            $('#tbl-tel .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            num = tr.find('td:eq(0)').text();
            ext = tr.find('td:eq(1)').text();

            $('#tel-num').parents('form').removeClass('hide');
            $('#tel-ext').val(ext);
            $('#tel-num').val(num).focus();
          });

          $('#tel-num').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveTel').trigger('click'); } });

          $('#btnSaveTel').click(function() {
            num = $.trim($('#tel-num').val());
            ext = $.trim($('#tel-ext').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-tel .info').length > 0) id = $('#tbl-tel .info').data('id');

            if(num.length < 4){
              setError('tel-num', 'Debe ingresar el número');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addTelefono';
              if(parseInt(id,10) > 0) act = 'editTelefono';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, num: num, ext: ext}, 
                function(resp) {
                  if(!resp.error){
                    addTelRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-tel .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveTel', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btnt-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            num = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delTelefono', num: num, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** CORREOS **/
          $('#btnAddM').click(function() {
            $('#mail-mail').parents('form').removeClass('hide');
            $('#tbl-mail .info').removeClass('info');
            $('#mail-mail').val('').focus();
          });

          $('body').on('click', '.btnm-edit', function(){
            $('#tbl-mail .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            mail = tr.find('td:eq(0)').text();

            $('#mail-mail').parents('form').removeClass('hide');
            $('#mail-mail').val(mail).focus();
          });

          $('#mail-mail').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveM').trigger('click'); } });

          $('#btnSaveM').click(function() {
            mail = $.trim($('#mail-mail').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-mail .info').length > 0) id = $('#tbl-mail .info').data('id');

            if(mail.length < 4){
              setError('mail-mail', 'Debe ingresar el email');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addCorreo';
              if(parseInt(id,10) > 0) act = 'editCorreo';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, mail: mail}, 
                function(resp) {
                  if(!resp.error){
                    addMailRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-mail .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveCel', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btnm-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            mail = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delCorreo', mail: mail, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** PAGINAS **/
          $('#btnAddPag').click(function() {
            $('#pag-nom').parents('form').removeClass('hide');
            $('#tbl-pag .info').removeClass('info');
            $('#pag-dir').val('');
            $('#pag-nom').val('').focus();
          });

          $('body').on('click', '.btnp-edit', function(){
            $('#tbl-pag .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            nom = tr.find('td:eq(0)').text();
            dir = tr.find('td:eq(1)').text();

            $('#pag-nom').parents('form').removeClass('hide');
            $('#pag-dir').val(dir);
            $('#pag-nom').val(nom).focus();
          });

          $('#pag-dir').keydown(function (key) { if (key.keyCode == '13') { $('#btnSavePag').trigger('click'); } });

          $('#btnSavePag').click(function() {
            nom = $.trim($('#pag-nom').val());
            dir = $.trim($('#pag-dir').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-pag .info').length > 0) id = $('#tbl-pag .info').data('id');

            if(nom.length < 4){
              setError('pag-nom', 'Debe ingresar el nombre');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addPagina';
              if(parseInt(id,10) > 0) act = 'editPagina';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, nom: nom, dir: dir}, 
                function(resp) {
                  if(!resp.error){
                    addPagRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-pag .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSavePag', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btnp-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            nom = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delPagina', nom: nom, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** IDIOMAS **/
          $("#idi-esc").inputmask('integer',{min:0, max:100});
          $("#idi-hab").inputmask('integer',{min:0, max:100});
          $('#btnAddIdi').click(function() {
            $('#idi-idi').parents('form').removeClass('hide');
            $('#tbl-idi .info').removeClass('info');
            $('#idi-idi').val('').focus();
            $('#idi-esc').val('');
            $('#idi-hab').val('');
          });

          $('body').on('click', '.btni-edit', function(){
            $('#tbl-idi .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            idi = tr.find('td:eq(0)').text();
            hab = tr.find('td:eq(1)').text();
            esc = tr.find('td:eq(1)').text();

            $('#idi-idi').parents('form').removeClass('hide');
            $('#idi-idi').val(idi);
            $('#idi-hab').val(hab).focus();
            $('#idi-esc').val(esc);
          });

          $('#idi-esc').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveIdi').trigger('click'); } });

          $('#btnSaveIdi').click(function() {
            idi = $.trim($('#idi-idi').val());
            hab = $.trim($('#idi-hab').val());
            esc = $.trim($('#idi-esc').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-idi .info').length > 0) id = $('#tbl-idi .info').data('id');

            if(hab.length == ''){
              setError('idi-hab', 'Debe ingresar el porcentaje');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addIdioma';
              if(parseInt(id,10) > 0) act = 'editIdioma';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, idi: idi, hab: hab, esc: esc}, 
                function(resp) {
                  if(!resp.error){
                    addIdiRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-idi .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveIdi', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btni-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            idi = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delIdioma', idi: idi, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** EXPERIENCIA CLINICA **/
          $('#btnAddEC').click(function() {
            $('#expc-desc').parents('form').removeClass('hide');
            $('#tbl-expc .info').removeClass('info');
            $('#expc-desc').val('').focus();
          });

          $('body').on('click', '.btnec-edit', function(){
            $('#tbl-expc .info').removeClass('info');
            tr = $(this).parents('tr');
            tr.addClass('info');
            desc = tr.find('td:eq(0)').text();

            $('#expc-desc').parents('form').removeClass('hide');
            $('#expc-desc').val(desc).focus();
          });

          $('#btnSaveEC').click(function() {
            desc = $.trim($('#expc-desc').val());
            med = $('#med-id').val();

            id = 0;
            if($('#tbl-expc .info').length > 0) id = $('#tbl-expc .info').data('id');

            if(desc.length < 4){
              setError('expc-desc', 'Debe ingresar el nombre');
            }else{
              btn = $(this);
              btn.addClass('disabled');
              frm = btn.parents('form');

              act = 'addExpCli';
              if(parseInt(id,10) > 0) act = 'editExpCli';
              NProgress.start();
              $.post('/core/medicos.php', 
                {action: act, id: id, med: med, desc: desc}, 
                function(resp) {
                  if(!resp.error){
                    addECRow(resp.item, resp.act);
                    frm.addClass('hide');
                    $('#tbl-expc .info').removeClass('info');
                    btn.removeClass('disabled');
                  }else{
                    setError('btnSaveEC', resp.msg);
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
              },'json');
            }
          });

          $('body').on('click', '.btnec-del', function(){
            tr = $(this).parents('tr');
            id = tr.data('id');
            nom = tr.find('td:eq(0)').text();

            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                '/core/medicos.php',
                {action: 'delExpCli', nom: nom, id: id},
                function(resp){
                  if(!resp.error){
                    tr.remove();
                  }
                  NProgress.done();
                },'json');
          });


        /** EXPERIENCIA QUIRURGICA **/
        $('#btnAddEQ').click(function() {
          $('#expq-desc').parents('form').removeClass('hide');
          $('#tbl-expq .info').removeClass('info');
          $('#expq-desc').val('').focus();
        });

        $('body').on('click', '.btneq-edit', function(){
          $('#tbl-expq .info').removeClass('info');
          tr = $(this).parents('tr');
          tr.addClass('info');
          desc = tr.find('td:eq(0)').text();

          $('#expq-desc').parents('form').removeClass('hide');
          $('#expq-desc').val(desc).focus();
        });

        $('#btnSaveEQ').click(function() {
          desc = $.trim($('#expq-desc').val());
          med = $('#med-id').val();

          id = 0;
          if($('#tbl-expq .info').length > 0) id = $('#tbl-expq .info').data('id');

          if(desc.length < 4){
            setError('expq-desc', 'Debe ingresar el nombre');
          }else{
            btn = $(this);
            btn.addClass('disabled');
            frm = btn.parents('form');

            act = 'addExpQui';
            if(parseInt(id,10) > 0) act = 'editExpQui';
            NProgress.start();
            $.post('/core/medicos.php', 
              {action: act, id: id, med: med, desc: desc}, 
              function(resp) {
                if(!resp.error){
                  addEQRow(resp.item, resp.act);
                  frm.addClass('hide');
                  $('#tbl-expq .info').removeClass('info');
                  btn.removeClass('disabled');
                }else{
                  setError('btnSaveEQ', resp.msg);
                  btn.removeClass('disabled');
                }
                NProgress.done();
            },'json');
          }
        });

        $('body').on('click', '.btneq-del', function(){
          tr = $(this).parents('tr');
          id = tr.data('id');
          nom = tr.find('td:eq(0)').text();

          btn = $(this);
          btn.addClass('disabled');
          NProgress.start();
          $.post(
              '/core/medicos.php',
              {action: 'delExpQui', nom: nom, id: id},
              function(resp){
                if(!resp.error){
                  tr.remove();
                }
                NProgress.done();
              },'json');
        });


        /** ESTUDIOS Y TRATAMIENTOS **/
        $('#btnAddET').click(function() {
          $('#expt-desc').parents('form').removeClass('hide');
          $('#tbl-expt .info').removeClass('info');
          $('#expt-desc').val('').focus();
        });

        $('body').on('click', '.btnet-edit', function(){
          $('#tbl-expt .info').removeClass('info');
          tr = $(this).parents('tr');
          tr.addClass('info');
          desc = tr.find('td:eq(0)').text();

          $('#expt-desc').parents('form').removeClass('hide');
          $('#expt-desc').val(desc).focus();
        });

        $('#btnSaveET').click(function() {
          desc = $.trim($('#expt-desc').val());
          med = $('#med-id').val();

          id = 0;
          if($('#tbl-expt .info').length > 0) id = $('#tbl-expt .info').data('id');

          if(desc.length < 4){
            setError('expt-desc', 'Debe ingresar el nombre');
          }else{
            btn = $(this);
            btn.addClass('disabled');
            frm = btn.parents('form');

            act = 'addEstTrat';
            if(parseInt(id,10) > 0) act = 'editEstTrat';
            NProgress.start();
            $.post('/core/medicos.php', 
              {action: act, id: id, med: med, desc: desc}, 
              function(resp) {
                if(!resp.error){
                  addETRow(resp.item, resp.act);
                  frm.addClass('hide');
                  $('#tbl-expt .info').removeClass('info');
                  btn.removeClass('disabled');
                }else{
                  setError('btnSaveEQ', resp.msg);
                  btn.removeClass('disabled');
                }
                NProgress.done();
            },'json');
          }
        });

        $('body').on('click', '.btnet-del', function(){
          tr = $(this).parents('tr');
          id = tr.data('id');
          nom = tr.find('td:eq(0)').text();

          btn = $(this);
          btn.addClass('disabled');
          NProgress.start();
          $.post(
              '/core/medicos.php',
              {action: 'delEstTrat', nom: nom, id: id},
              function(resp){
                if(!resp.error){
                  tr.remove();
                }
                NProgress.done();
              },'json');
        });


        
        /** CURRICULUM **/
        $("[id*=-anio]").inputmask('integer',{min:1950, max:2016});
        $('.btnAddCurr').click(function() {
          tipo = $(this).data('tipo');

          $('#'+tipo+'-desc').parents('form').removeClass('hide');
          $('#tbl-'+tipo+' .info').removeClass('info');
          $('#'+tipo+'-anio').val('');
          $('#'+tipo+'-desc').val('').focus();
        });

        $('body').on('click', '.btncurr-edit', function(){
          tipo = $(this).parents('tr').data('tipo');

          $('#tbl-'+tipo+' .info').removeClass('info');
          tr = $(this).parents('tr');
          tr.addClass('info');
          desc = tr.find('td:eq(0)').text();
          anio = tr.find('td:eq(1)').text();

          $('#'+tipo+'-desc').parents('form').removeClass('hide');
          $('#'+tipo+'-desc').val(desc).focus();
          $('#'+tipo+'-anio').val(anio);
        });

        $('.btnSaveCurr').click(function() {
          tipo = $(this).data('tipo');
          desc = $.trim($('#'+tipo+'-desc').val());
          anio = $.trim($('#'+tipo+'-anio').val());
          med = $('#med-id').val();

          id = 0;
          if($('#tbl-'+tipo+' .info').length > 0) id = $('#tbl-'+tipo+' .info').data('id');
          //console.log($.inArray(tipo, arrCur))
          if(desc.length < 4){
            setError(''+tipo+'-desc', 'Debe ingresar la descripción');
          }else{
            btn = $(this);
            btn.addClass('disabled');
            frm = btn.parents('form');

            act = 'addCurriculum';
            if(parseInt(id,10) > 0) act = 'editCurriculum';
            NProgress.start();
            $.post('/core/medicos.php', 
              {action: act, id: id, med: med, desc: desc, anio: anio, tipo: $.inArray(tipo, arrCur)}, 
              function(resp) {
                if(!resp.error){
                  addCurRow(resp.item, resp.act, tipo);
                  frm.addClass('hide');
                  $('#tbl-'+tipo+' .info').removeClass('info');
                  btn.removeClass('disabled');
                }else{
                  //setError('btnSaveEQ', resp.msg);
                  btn.removeClass('disabled');
                }
                NProgress.done();
            },'json');
          }
        });

        $('body').on('click', '.btncurr-del', function(){
          tr = $(this).parents('tr');
          id = tr.data('id');
          tipo = tr.data('tipo');
          nom = tr.find('td:eq(0)').text();

          btn = $(this);
          btn.addClass('disabled');
          NProgress.start();
          $.post(
              '/core/medicos.php',
              {action: 'delCurriculum', nom: nom, id: id, tipo: tipo},
              function(resp){
                if(!resp.error){
                  tr.remove();
                }
                NProgress.done();
              },'json');
        });


        /** FACTURACION **/
        $('#fact-cp').change(function() {
          cp = $.trim($(this).val());
          $('#fact-col').empty().addClass('disabled');
          NProgress.start();
          $.post('/core/medicos.php', 
            {action: 'getCP', cp: cp}, 
            function(resp) {
              if(resp.success){
                $('#fact-mun').val(resp.muni);
                $('#fact-ciu').val(resp.ciudad);
                $('#fact-edo').val(resp.estado);
                $.each(resp.colonia, function(index, val) {
                  $('#fact-col').append('<option value="'+val+'">'+val+'</option>');
                });
                $('#fact-col').removeClass('disabled');
              }else{
                setError('fact-cp','Verifique el Código Postal');
              }
              NProgress.done();
          },'json');
        });

        $('#btnSaveFact').click(function() {
          $('.alert').remove();
          $('.tooltip-error').remove();
          data = { med: $('#med-id').val() }

          $.each($("[id*=fact-]"), function(index, el) {
            id = $(el).attr('id');
            id = id.replace('fact-', '');

            data[id] = $.trim($(el).val());
          });

          btn = $(this);
          btn.addClass('disabled');
          NProgress.start();

          $.post('/core/medicos.php', 
            {action: 'saveFact', data: $.toJSON(data)}, 
            function(resp) {
              if(resp.success){
                $('#fact-id').val(resp.id);
                al = $('<div class="alert alert-success alert-dismissible fade in">Se guardaron los datos correctamente</div>');
                $('#fact-id').after(al);
                setTimeout(function(){ al.remove(); }, 7000);
              }else{
                setError('btnSaveFact', 'Ha ocurrido un error al guardar')
              }
              btn.removeClass('disabled');
              NProgress.done();
          },'json');
        });


        /** CONSULTORIOS **/
        $('.btnNextC').click(function() {
          $('html, body').animate({
              scrollTop: 0//$("#med-id").offset().top
          }, 500);
          next = $(this).data('next');
          $('#consTabs li:eq('+next+') a').tab('show');
        });

        $('#btnAddCons').click(function() {
          $('#cons-info input').val('');
          //$('#cons-id').val('0');
          $('#cons-tbl').addClass('col-sm-8').addClass('col-md-8').removeClass('col-sm-12').removeClass('col-md-12');
          $('#cons-info').removeClass('hide');
          $('#datos-cons').addClass('hide');
          $('#cons-nom').focus();
        });

        $('body').on('click', '.btncons-edit', function(){
          $('#tbl-cons .info').removeClass('info');
          tr = $(this).parents('tr');
          tr.addClass('info');
          nom = tr.find('td:eq(0)').text();
          prim = tr.find('td:eq(1)').text();
          sub = tr.find('td:eq(2)').text();
          pref = tr.find('td:eq(3)').text();

          $('#cons-prim').val(prim);
          $('#cons-sub').val(sub);
          $('#cons-pref').val(pref);
          $('#cons-nom').val(nom).focus();

          $('#cons-tbl').addClass('col-sm-8').addClass('col-md-8').removeClass('col-sm-12').removeClass('col-md-12');
          $('#cons-info').removeClass('hide');
          $('#datos-cons').removeClass('hide');

          cons = tr.data('id');
          getConv(cons);
        });

        $(".time").inputmask("h:s");
        
      });

      function getInst(med){
        NProgress.start();
        $.post('/core/medicos.php', 
          {action: 'getInstituciones', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addInstRow(item, resp.act);
            });
            //NProgress.done();
            getCons(med);
        },'json');
      }

      function addInstRow(item, act){
        nuevo = true;
        //tr = $('<tr></tr>');
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-inst [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-inst [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-inst tbody').append(tr);
      }

      function getCons(med){
        $.post('/core/medicos.php', 
          {action: 'getConsultorios', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              tr = $('<tr data-id="'+item.ID+'"></tr>');
              tr.append('<td>'+item.nombre+'</td>');
              tr.append('<td>'+item.consultaPrimera+'</td>');
              tr.append('<td>'+item.consultaSubsecuente+'</td>');
              tr.append('<td>'+item.consultaPreferente+'</td>');
              tr.append('<td>'+resp.act+'</td>');

              $('#tbl-cons tbody').append(tr);
            });
            getCont(med);
        },'json');
      }

      function getCont(med){
        //NProgress.start();
        $.post('/core/medicos.php', 
          {action: 'getContactos', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addContRow(item, resp.act);
            });
            //NProgress.done();
            getCel(med);
        },'json');
      }

      function addContRow(item, act){
        nuevo = true;
        //tr = $('<tr></tr>');
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-cont [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-cont [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td><span>'+item.nombre+'</span> <span>'+item.paterno+'</span> <span>'+item.materno+'</span></td>');
        tr.append('<td>'+item.area+'</td>');
        tr.append('<td>'+item.puesto+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-cont tbody').append(tr);
      }

      function getCel(med){
        //NProgress.start();
        $.post('/core/medicos.php', 
          {action: 'getCelulares', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addCelRow(item, resp.act);
            });
            //NProgress.done();
            getTel(med);
        },'json');
      }

      function addCelRow(item, act){
        nuevo = true;
        //tr = $('<tr></tr>');
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-cel [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-cel [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.numero+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-cel tbody').append(tr);
      }

      function getTel(med){
        //NProgress.start();
        $.post('/core/medicos.php', 
          {action: 'getTelefonos', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addTelRow(item, resp.act);
            });
            //NProgress.done();
            getMail(med);
        },'json');
      }

      function addTelRow(item, act){
        nuevo = true;
        //tr = $('<tr></tr>');
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-tel [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-tel [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.numero+'</td>');
        tr.append('<td>'+item.ext+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-tel tbody').append(tr);
      }

      function getMail(med){
        //NProgress.start();
        $.post('/core/medicos.php', 
          {action: 'getCorreos', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addMailRow(item, resp.act);
            });
            getPag(med);
        },'json');
      }

      function addMailRow(item, act){
        nuevo = true;
        //tr = $('<tr></tr>');
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-mail [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-mail [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.correo+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-mail tbody').append(tr);
      }

      function getPag(med){
        $.post('/core/medicos.php', 
          {action: 'getPaginas', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addPagRow(item, resp.act);
            });
            getIdi(med);
        },'json');
      }

      function addPagRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-pag [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-pag [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.pagina+'</td>');
        tr.append('<td>'+item.direccion+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-pag tbody').append(tr);
      }

      function getIdi(med){
        $.post('/core/medicos.php', 
          {action: 'getIdiomas', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addIdiRow(item, resp.act);
            });
            getEC(med);
        },'json');
      }

      function addIdiRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-idi [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-idi [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.idioma+'</td>');
        tr.append('<td>'+item.hablado+'</td>');
        tr.append('<td>'+item.escrito+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-idi tbody').append(tr);
      }

      function getEC(med){
        $.post('/core/medicos.php', 
          {action: 'getExpCli', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addECRow(item, resp.act);
            });
            getEQ(med);
        },'json');
      }

      function addECRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-expc [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-expc [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-expc tbody').append(tr);
      }

      function getEQ(med){
        $.post('/core/medicos.php', 
          {action: 'getExpQui', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addEQRow(item, resp.act);
            });
            getET(med);
        },'json');
      }

      function addEQRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-expq [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-expq [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-expq tbody').append(tr);
      }

      function getET(med){
        $.post('/core/medicos.php', 
          {action: 'getEstTrat', med: med}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addETRow(item, resp.act);
            });
            getCur(med,0);
        },'json');
      }

      function addETRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-expt [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-expt [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-expt tbody').append(tr);
      }

      arrCur = ['uni', 'cert', 'con', 'cur', 'esp'];
      function getCur(med, tipo){
        $.post('/core/medicos.php', 
          {action: 'getCurriculum', med: med, tipo: tipo}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addCurRow(item, resp.act, arrCur[tipo]);
            });

            if(tipo < 4)
              getCur(med,tipo+1);
            else
              NProgress.done();
            //getCont(med);
        },'json');
      }

      function addCurRow(item, act, tbl){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'" data-tipo="'+tbl+'"></tr>');
        if($("#tbl-"+tbl+" [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-"+tbl+" [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+item.anio+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-'+tbl+' tbody').append(tr);
      }

      function getConv(cons){
        NProgress.start();
        $('#tbl-conv tbody').empty();
        $.post('/core/medicos.php', 
          {action: 'getConvenios', cons: cons}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addConvRow(item, resp.act);
            });
            getAse(cons);
        },'json');
      }

      function addConvRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-conv [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-conv [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.empresa+'</td>');
        tr.append('<td>'+item.costo+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-conv tbody').append(tr);
      }

      function getAse(cons){
        $('#tbl-ase tbody').empty();
        $.post('/core/medicos.php', 
          {action: 'getAseguradoras', cons: cons}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              addAseRow(item, resp.act);
            });
            //getAse(cons);
            NProgress.done();
        },'json');
      }

      function addAseRow(item, act){
        nuevo = true;
        tr = $('<tr data-id="'+item.ID+'"></tr>');
        if($("#tbl-ase [data-id='"+item.ID+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-ase [data-id='"+item.ID+"']");
          tr.empty();
        }
        
        tr.append('<td>'+item.aseguradora+'</td>');
        tr.append('<td>'+item.costo+'</td>');
        tr.append('<td>'+act+'</td>');

        if(nuevo) $('#tbl-ase tbody').append(tr);
      }


    </script>
