                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <span class="section">Promociones</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-4 col-sm-10 col-xs-12">
                              <input type="text" id="promo-nom" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Nombre Promoción" maxlength="40">
                            </div>
                            <div class="col-md-3 col-sm-10 col-xs-12">
                              <input type="text" id="promo-cve" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Clave Promoción" maxlength="15">
                            </div>
                          </div>
                          <div class="form-group promo-serv">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" id="promo-serv" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="servicio_med" placeholder="Nombre del servicio">
                              <input type="hidden" id="promo-servid" value="0">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="promo-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" id="promo-costo" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm text-right" placeholder="Costo">
                              <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="promo-desde" class="control-label col-md-2 col-sm-2 col-xs-12">Vigencia</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" class="form-control has-feedback-left datepicker input-sm" id="promo-desde" placeholder="Desde" data-inputmask="'mask': '99/99/9999'" >
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" class="form-control has-feedback-left datepicker input-sm" id="promo-hasta" placeholder="Hasta" data-inputmask="'mask': '99/99/9999'" >
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <label for="promo-descu" class="control-label col-md-2 col-sm-2 col-xs-12">Descuento</label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="number" min="5" max="100" id="promo-descu" class="form-control has-feedback-right col-md-7 col-xs-12 input-sm text-right">
                              <span class="form-control-feedback right" aria-hidden="true">%</span>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" id="promo-costod" class="form-control has-feedback-left col-md-7 col-xs-12 input-sm text-right" placeholder="Costo con descuento" disabled>
                              <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="promo-cond" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="condicion" placeholder="Condiciones de la Promoción" maxlength="300">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 text-right">
                              <button type="button" class="btn btn-sm btn-default" id="btnCancelPromo"><i class="fa fa-remove"></i></button>
                              <button type="button" class="btn btn-sm btn-primary" id="btnSavePromo"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-promo" class="table table-striped jambo_table">
                          <thead>
                            <th>Nombre</th>
                            <th>Servicio</th>
                            <th>Lista</th>
                            <th>Descuento</th>
                            <th>Vigencia</th>
                            <th>Calificar</th>
                            <th>
                              <?php if($edita) : ?>
                              <button type="button" class="btn btn-xs btn-default" id="btnAddPromo"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="actionBar">
                      <button type="button" class="btn btn-default btnNextC" data-next="2"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-default btnNextC" data-next="4">Siguiente <i class="fa fa-angle-double-right"></i></button>
                    </div>