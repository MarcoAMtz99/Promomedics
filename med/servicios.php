                    <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-12">
                        <span class="section">Catálogo de Servicios</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" id="serv-nom" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="servicio" placeholder="Nombre del servicio">
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input type="text" id="serv-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" id="serv-costo" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm text-right" placeholder="Costo">
                              <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                              <button id="btnSaveServ" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                          <!--div class="form-group">
                            <label for="fact-razon" class="control-label col-md-4 col-sm-4 col-xs-12">Descuento</label>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                              <input type="number" min="5" max="100" id="serv-descu" class="form-control input-sm">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" id="serv-motivo" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Motivo">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" id="serv-costod" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm text-right" placeholder="Costo con descuento" disabled>
                              <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                              <button id="btnSaveServ" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div-->
                        </form>
                        <?php endif; ?>

                        <table id="tbl-serv" class="table table-striped jambo_table">
                          <thead>
                              <th>Nombre del Servicio</th>
                              <th>Descripción</th>
                              <th>Costo</th>
                              <th>
                                <?php if($edita) : ?>
                                <button id="btnAddServ" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                <?php endif; ?>
                              </th>
                              <th class="serv-desc">Descuento</th>
                              <th class="serv-desc">Costo Desc</th>
                            </thead>
                          <tbody>
                          </tbody>
                        </table>

                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Listas de Descuento</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text" id="descu-motivo" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="motivo" placeholder="Motivo">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <input type="number" min="5" max="100" id="descu-descu" class="form-control input-sm">
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                              <button id="btnSaveDescu" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-descu" class="table table-striped jambo_table">
                          <thead>
                              <th>Motivo</th>
                              <th>Descuento</th>
                              <th>
                                <?php if($edita) : ?>
                                <button id="btnAddDescu" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                <?php endif; ?>
                              </th>
                            </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="actionBar">
                      <button type="button" class="btn btn-default btnNextC" data-next="1"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-default btnNextC" data-next="3">Siguiente <i class="fa fa-angle-double-right"></i></button>
                    </div>