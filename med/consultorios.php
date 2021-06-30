                    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
                    </div>

                    <div id="cons-info" class="row">
                      <div class="col-md-4 col-sm-12 col-xs-12">
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
                          
                          <?php if($edita) : ?>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                              <input type="hidden" id="cons-id" value="0">
                              <button id="btnSaveCons" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Guardar Datos</button>
                            </div>
                          </div>
                          <?php endif; ?>
                        </form>
                      </div>

                      <div class="col-md-8 col-sm-12 col-xs-12">
                        <span class="section">Dirección</span>

                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cons-calle">Calle 
                            </label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="cons-calle" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre de la calle">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="cons-ext" class="control-label col-md-2 col-sm-2 col-xs-12">No. Ext.</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="cons-ext" class="form-control col-md-7 col-xs-12" type="text" placeholder="Número Exterior">
                            </div>
                            <label for="cons-int" class="control-label col-md-1 col-sm-1 col-xs-12">No. Int.</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="cons-int" class="form-control col-md-7 col-xs-12" type="text" placeholder="Número Interior">
                            </div>
                            <label for="cons-cp" class="control-label col-md-1 col-sm-1 col-xs-12">C. P.</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input id="cons-cp" class="form-control col-md-7 col-xs-12" type="text" data-inputmask="'mask' : '99999'" placeholder="Código Postal">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="cons-col" class="control-label col-md-2 col-sm-2 col-xs-12">Colonia</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select id="cons-col" class="select2_single form-control" tabindex="-1" style="width: 100%">
                              </select>
                            </div>
                            <label for="cons-mun" class="control-label col-md-1 col-sm-1 col-xs-12">Municipio</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input id="cons-mun" class="form-control col-md-7 col-xs-12" type="text" placeholder="Delegación / Municipio">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="cons-ciu" class="control-label col-md-2 col-sm-2 col-xs-12">Ciudad</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input id="cons-ciu" class="form-control col-md-7 col-xs-12" type="text" placeholder="Ciudad">
                            </div>
                            <label for="cons-edo" class="control-label col-md-1 col-sm-1 col-xs-12">Estado</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input id="cons-edo" class="form-control col-md-7 col-xs-12" type="text" placeholder="Estado">
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>
                    

                    <div id="datos-cons" class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--span class="section">Datos del Consultorio</span-->

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="consTabs" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active">
                              <a href="#tab_cgral" role="tab" data-toggle="tab" aria-expanded="true">General</a>
                            </li>
                            <li role="presentation">
                              <a href="#tab_chor" role="tab" data-toggle="tab" aria-expanded="true">Horarios Atención</a>
                            </li>
                            <?php if($infoMed['servicios'] == 1) : ?>
                            <li role="presentation">
                              <a href="#tab_cserv" role="tab" data-toggle="tab" aria-expanded="true">Servicios</a>
                            </li>
                            <li role="presentation">
                              <a href="#tab_cpromo" role="tab" data-toggle="tab" aria-expanded="true">Promociones</a>
                            </li>
                            <?php endif; ?>
                            <li role="presentation">
                              <a href="#tab_ccub" role="tab" data-toggle="tab" aria-expanded="true">Cubículos</a>
                            </li>
                            <!--li role="presentation">
                              <a href="#tab_cdig" role="tab" data-toggle="tab" aria-expanded="true">Medios Digitales</a>
                            </li-->
                            <li role="presentation">
                              <a href="#tab_cstaff" role="tab" data-toggle="tab" aria-expanded="true">Staff Médico</a>
                            </li>
                            <span class="pull-right"></span>
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
                                        <input type="text" id="conv-desc" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="convenio" placeholder="Empresa de Convenio">
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
                                        <input type="text" id="ase-desc" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="aseguradora" placeholder="Aseguradora">
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
                                <!--button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="1">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                                <button type="button" class="btn btn-default btnNext" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                <button type="button" class="btn btn-default btnNextC" data-next="1">Siguiente <i class="fa fa-angle-double-right"></i></button>
                              </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tab_chor" aria-labelledby="horarios-tab">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <span class="section">Horarios de Consulta</span>

                                  <form class="form-horizontal form-label-left">
                                    <div class="form-group">
                                      <div class="col-md-7 col-sm-7 col-xs-12">
                                        <label class="checkbox pull-right" style="display:inline-block"><input type="checkbox" id="hora-all" value="0" class="flat"> Todos</label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-lun" data-dia="1" class="flat hora-dias"> Lunes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-mar" data-dia="2" class="flat hora-dias"> Martes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-mie" data-dia="3" class="flat hora-dias"> Miercoles
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-jue" data-dia="4" class="flat hora-dias"> Jueves
                                        </label>
                                      <!--/div>
                                      <div class="col-md-6 col-sm-6 col-xs-12"-->
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-vie" data-dia="5" class="flat hora-dias"> Viernes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-sab" data-dia="6" class="flat hora-dias"> Sábado
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="hora-dom" data-dia="7" class="flat hora-dias"> Domingo
                                        </label>
                                      </div>
                                      <div class="col-md-3 col-sm-3 col-xs-12">
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="hora-ini" class="form-control input-sm has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="hora-fin" class="form-control input-sm has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      </div>

                                      <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                        <button id="btnClearH" type="button" class="btn btn-sm btn-default">Limpiar</button> 
                                        <button id="btnSaveH" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Agregar</button>
                                      </div>
                                    </div>
                                  </form>

                                  <table id="tbl-hora" class="table table-striped jambo_table">
                                    <thead>
                                      <tr>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miercoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr class="nodata"><td colspan="7">Cargando horarios..</td></tr>
                                    </tbody>
                                  </table>

                                </div>
                                <!--div class="col-md-3 col-sm-3 col-xs-12">
                                  <span class="section">Agregar Horario</span>
                                  
                                  <form class="form-horizontal form-label-left">
                                    <div class="form-group">
                                      <label class="control-label col-md-1 col-sm-1 col-xs-12 text-left hide" for="hora-ini">Días</label>
                                      <div class="col-md-6 col-sm-6 col-xs-12"></div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="checkbox"><input type="checkbox" id="hora-all" value="0" class="flat"> Todos</label>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-lun" data-dia="1" class="flat hora-dias"> Lunes
                                        </label>
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-mar" data-dia="2" class="flat hora-dias"> Martes
                                        </label>
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-mie" data-dia="3" class="flat hora-dias"> Miercoles
                                        </label>
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-jue" data-dia="4" class="flat hora-dias"> Jueves
                                        </label>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-vie" data-dia="5" class="flat hora-dias"> Viernes
                                        </label>
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-sab" data-dia="6" class="flat hora-dias"> Sábado
                                        </label>
                                        <label class="checkbox">
                                          <input type="checkbox" id="hora-dom" data-dia="7" class="flat hora-dias"> Domingo
                                        </label>
                                      </div>
                                    </div>
                                    <div class="form-group hide">
                                      <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left" for="hora-ini">Inicio - Fin</label>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="hora-ini" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="hora-fin" class="form-control has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                        <button id="btnClearH" type="button" class="btn btn-sm btn-default">Limpiar</button> 
                                        <button id="btnSaveH" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Agregar</button>
                                      </div>
                                    </div>
                                  </form>
                                </div-->
                              </div>

                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <span class="section">Horarios Quirúrgicos</span>

                                  <form class="form-horizontal form-label-left">
                                    <div class="form-group">
                                      <div class="col-md-7 col-sm-7 col-xs-12">
                                        <label class="checkbox pull-right" style="display:inline-block"><input type="checkbox" id="horaq-all" value="0" class="flat"> Todos</label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-lun" data-dia="1" class="flat horaq-dias"> Lunes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-mar" data-dia="2" class="flat horaq-dias"> Martes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-mie" data-dia="3" class="flat horaq-dias"> Miercoles
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-jue" data-dia="4" class="flat horaq-dias"> Jueves
                                        </label>
                                      <!--/div>
                                      <div class="col-md-6 col-sm-6 col-xs-12"-->
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-vie" data-dia="5" class="flat horaq-dias"> Viernes
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-sab" data-dia="6" class="flat horaq-dias"> Sábado
                                        </label>
                                        <label class="checkbox" style="display:inline-block">
                                          <input type="checkbox" id="horaq-dom" data-dia="7" class="flat horaq-dias"> Domingo
                                        </label>
                                      </div>
                                      <div class="col-md-3 col-sm-3 col-xs-12">
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="horaq-ini" class="form-control input-sm has-feedback-left col-md-7 col-xs-12 time" placeholder="Inicio">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="horaq-fin" class="form-control input-sm has-feedback-left col-md-7 col-xs-12 time" placeholder="Fin">
                                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                                      </div>
                                      </div>

                                      <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                        <button id="btnClearHQ" type="button" class="btn btn-sm btn-default">Limpiar</button> 
                                        <button id="btnSaveHQ" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Agregar</button>
                                      </div>
                                    </div>
                                    <!--div class="form-group">
                                      <label class="control-label col-md-1 col-sm-1 col-xs-12 text-left hide" for="horaq-ini">Días</label>
                                      <div class="col-md-6 col-sm-6 col-xs-12"></div>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                      </div>
                                    </div>
                                    <div class="form-group hide">
                                      <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left" for="horaq-ini">Inicio - Fin</label>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                    <div class="form-group">
                                      <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                      </div>
                                    </div-->
                                  </form>

                                  <table id="tbl-horaq" class="table table-striped jambo_table">
                                    <thead>
                                      <tr>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miercoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr class="nodata"><td colspan="7">Cargando horarios..</td></tr>
                                    </tbody>
                                  </table>

                                </div>
                              </div>


                              <div class="actionBar">
                                <input type="hidden" id="horac-id" value="0">
                                <input type="hidden" id="horaq-id" value="0">
                                <!--button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button-->
                                <button type="button" class="btn btn-default btnNextC" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                <button id="btnSaveHor" type="button" class="btn btn-primary hide"><i class="fa fa-check"></i> Guardar Horarios</button>
                                <!--button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                                <button type="button" class="btn btn-default btnNextC" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button>
                              </div>
                            </div>

                            <?php if($infoMed['servicios'] == 1) : ?>
                            <div role="tabpanel" class="tab-pane fade" id="tab_cserv" aria-labelledby="servicios-tab">
                              <?php include 'med/servicios.php'; ?>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tab_cpromo" aria-labelledby="promociones-tab">
                              <?php include 'med/promociones.php'; ?>
                            </div>
                            <?php endif; ?>

                            <div role="tabpanel" class="tab-pane fade" id="tab_ccub" aria-labelledby="cubiculo-tab">
                              <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                  <span class="section">Cubículos</span>
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
                                        <input type="text" id="cub-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Cubículo">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cub-med">Médico Apoyo</label>
                                      <div class="col-md-10 col-sm-10 col-xs-12">
                                        <input type="text" id="cub-med" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico de Apoyo">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cub-desc">Características</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea class="form-control" id="cub-desc" rows="2" placeholder="Características"></textarea>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="col-md-7 col-sm-7 col-xs-12"></div>
                                      <div class="col-md-5 col-sm-5 col-xs-12 text-right">
                                        <?php if($edita) : ?>
                                        <button id="btnSaveCub" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Guardar</button>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>

                              <div class="actionBar">                          
                                <button type="button" class="btn btn-default btnNextC" data-next="<?php echo $infoMed['servicios'] == 1 ? '3' : '1' ?>"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                <button type="button" class="btn btn-default btnNextC" data-next="<?php echo $infoMed['servicios'] == 1 ? '5' : '3' ?>">Siguiente <i class="fa fa-angle-double-right"></i></button>
                              </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tab_cstaff" aria-labelledby="staff-tab">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <span class="section">Médicos Participantes</span>
                                  <form class="form-horizontal form-label-left hide">
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-nom">Nombre</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico">
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-ape">Apelidos</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-ape" class="form-control col-md-7 col-xs-12" placeholder="Apellidos">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-rol">Rol de Médico</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select id="medp-rol" class="form-control">
                                          <option value="Guardia">Guardia</option>
                                          <option value="Suplente">Suplente</option>
                                        </select>
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-ced">Cédula Médico</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-ced" class="form-control col-md-7 col-xs-12" placeholder="Cédula Médico">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-esp">Especialidad</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-esps" class="form-control ac-esp" placeholder="Especialidad">
                                        <input type="hidden" id="medp-esp" value="0">
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-sub">Subespecialidad</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-subs" class="form-control ac-subesp" placeholder="Subespecialidad">
                                        <input type="hidden" id="medp-sub" value="0">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medp-mail">Email</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medp-mail" class="form-control col-md-7 col-xs-12" placeholder="Correo electrónico">
                                      </div>
                                      <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                        <button data-tipo="medp" type="button" class="btn btn-sm btn-default btnCancelStaff"><i class="fa fa-remove"></i></button> 
                                        <?php if($edita) : ?>
                                        <button data-tipo="medp" type="button" class="btn btn-sm btn-primary btnSaveStaff"><i class="fa fa-check"></i> Guardar</button>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </form>
                                  <table id="tbl-medp" class="table table-striped jambo_table">
                                    <thead>
                                      <th>Nombre</th>
                                      <th>Cédula</th>
                                      <th>Especialidad</th>
                                      <th>Rol de Médico</th>
                                      <th>Email</th>
                                      <th>
                                        <?php if($edita) : ?>
                                        <button data-tipo="medp" type="button" class="btn btn-xs btn-default btnAddStaff"><i class="fa fa-plus"></i> Agregar</button>
                                        <?php endif; ?>
                                      </th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <span class="section">Staff Médico Quirúrgico</span>
                                  <form class="form-horizontal form-label-left hide">
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-nom">Nombre</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico">
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-ape">Apelidos</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-ape" class="form-control col-md-7 col-xs-12" placeholder="Apellidos">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-rol">Rol de Médico</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select id="medq-rol" class="form-control">
                                          <option value="Apoyo">Apoyo</option>
                                          <option value="Guardia">Guardia</option>
                                          <option value="Pasante">Pasante</option>
                                          <option value="Suplente">Suplente</option>
                                          <option value="Titular">Titular</option>
                                        </select>
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-ced">Cédula Médico</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-ced" class="form-control col-md-7 col-xs-12" placeholder="Cédula Médico">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-esp">Especialidad</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-esps" class="form-control ac-esp" placeholder="Especialidad">
                                        <input type="hidden" id="medq-esp" value="0">
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-sub">Subespecialidad</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-subs" class="form-control ac-subesp" placeholder="Subespecialidad">
                                        <input type="hidden" id="medq-sub" value="0">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-cede">Cédula Especialidad</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-cede" class="form-control col-md-7 col-xs-12" placeholder="Cédula Especialidad">
                                      </div>
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-mail">Email</label>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" id="medq-mail" class="form-control col-md-7 col-xs-12" placeholder="Correo electrónico">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="medq-tel">Teléfono Consultorio</label>
                                      <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" id="medq-tel" class="form-control col-md-7 col-xs-12" placeholder="Teléfono Consultorio" data-inputmask="'mask' : '(999) 999-9999'">
                                      </div>
                                      <label class="control-label col-md-1 col-sm-1 col-xs-12" for="medq-cel">Celular</label>
                                      <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" id="medq-cel" class="form-control col-md-7 col-xs-12" placeholder="Celular" data-inputmask="'mask' : '(999) 999-9999'">
                                      </div>
                                      <label class="control-label col-md-1 col-sm-1 col-xs-12" for="medq-telo">Otro</label>
                                      <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input type="text" id="medq-telo" class="form-control col-md-7 col-xs-12" placeholder="Otro" data-inputmask="'mask' : '(999) 999-9999'">
                                      </div>
                                      <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                                        <button data-tipo="medq" type="button" class="btn btn-sm btn-default btnCancelStaff"><i class="fa fa-remove"></i></button> 
                                        <?php if($edita) : ?>
                                        <button data-tipo="medq" type="button" class="btn btn-sm btn-primary btnSaveStaff"><i class="fa fa-check"></i> Guardar</button>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </form>
                                  <table id="tbl-medq" class="table table-striped jambo_table">
                                    <thead>
                                      <th>Nombre</th>
                                      <th>Cédula</th>
                                      <th>Especialidad</th>
                                      <th>Rol de Médico</th>
                                      <th>Email</th>
                                      <th>
                                        <?php if($edita) : ?>
                                        <button data-tipo="medq" type="button" class="btn btn-xs btn-default btnAddStaff"><i class="fa fa-plus"></i> Agregar</button>
                                        <?php endif; ?>
                                      </th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                                <!--div class="col-md-4 col-sm-4 col-xs-12 ">
                                  <span class="section">Datos del Médico</span>

                                  <form class="form-horizontal form-label-left">
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-nom">Nombre</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-nom" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-ape">Apelidos</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-ape" class="form-control col-md-7 col-xs-12" placeholder="Apellidos">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-esp">Especialidad</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-esps" class="form-control ac-esp" placeholder="Especialidad">
                                        <input type="hidden" id="medq-esp" value="0">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-sub">Subespecialidad</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-subs" class="form-control ac-subesp" placeholder="Subespecialidad">
                                        <input type="hidden" id="medq-sub" value="0">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-rol">Rol de Médico</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select id="medq-rol" class="form-control">
                                          <option value="Titular">Titular</option>
                                          <option value="Pasante">Pasante</option>
                                          <option value="Apoyo">Apoyo</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-mail">Email</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-mail" class="form-control col-md-7 col-xs-12" placeholder="Correo electrónico">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medq-tel">Teléfono</label>
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="medq-tel" class="form-control col-md-7 col-xs-12" placeholder="Teléfono" data-inputmask="'mask' : '(999) 999-9999'">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="col-md-3 col-sm-3 col-xs-12"></div>
                                      <div class="col-md-5 col-sm-5 col-xs-12">
                                        <?php if($edita) : ?>
                                        <button data-tipo="medq" type="button" class="btn btn-sm btn-primary btnSaveStaff"><i class="fa fa-check"></i> Guardar</button>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </form>
                                </div-->
                              </div>

                              <div class="actionBar">                          
                                <button type="button" class="btn btn-default btnNextC" data-next="<?php echo $infoMed['servicios'] == 1 ? '4' : '2' ?>"><i class="fa fa-angle-double-left"></i> Anterior</button>
                                <button type="button" class="btn btn-default btnNext" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      
                      </div>
                    </div>

                    <!--div class="actionBar">                          
                      <button type="button" class="btn btn-default btnNext" data-next="0"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-default btnNext" data-next="2">Siguiente <i class="fa fa-angle-double-right"></i></button>
                    </div-->

