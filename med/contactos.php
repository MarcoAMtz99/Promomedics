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
                              <input type="text" id="cont-area" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="area" placeholder="Area">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="cont-pues">Puesto</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="cont-pues" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="puesto" placeholder="Puesto">
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

                    <div class="row cont-info hide">
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

                    <!--div class="row cont-info hide"-->
                    <div class="row hide">
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