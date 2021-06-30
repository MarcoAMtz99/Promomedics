                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Medios Digitales</span>
                        <form class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cmd-giro">Giro</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="cmd-giro" class="form-control col-md-7 col-xs-12" placeholder="Giro" value="<?php echo $infoMed['giro'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cmd-slo">Slogan</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="cmd-slo" class="form-control col-md-7 col-xs-12" placeholder="Slogan" value="<?php echo $infoMed['slogan'] ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-2 col-sm-2 col-xs-12"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <?php if($edita) : ?>
                              <button id="btnSaveCMD" type="button" class="btn btn-sm btn-primary hide"><i class="fa fa-check"></i> Guardar</button>
                              <?php endif; ?>
                            </div>
                          </div>
                        </form>

                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Principales productos o servicios</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="mdp-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción" maxlength="100">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button data-tipo="mdp" type="button" class="btn btn-sm btn-primary btnSaveDig"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-mdp" class="table table-striped jambo_table">
                          <thead>
                            <th>Descripción</th>
                            <th>
                              <?php if($edita) : ?>
                              <button data-tipo="mdp" type="button" class="btn btn-xs btn-default btnAddDig"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Descripción de sus servicios</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="mds-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción" maxlength="300">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button data-tipo="mds" type="button" class="btn btn-sm btn-primary btnSaveDig"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-mds" class="table table-striped jambo_table">
                          <thead>
                            <th>Descripción</th>
                            <th>
                              <?php if($edita) : ?>
                              <button data-tipo="mds" type="button" class="btn btn-xs btn-default btnAddDig"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Palabras Clave Sugeridas</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="pal-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción" maxlength="60">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button data-tipo="pal" type="button" class="btn btn-sm btn-primary btnSaveDig"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-pal" class="table table-striped jambo_table">
                          <thead>
                            <th>Descripción</th>
                            <th>
                              <?php if($edita) : ?>
                              <button data-tipo="pal" type="button" class="btn btn-xs btn-default btnAddDig"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Frases Clave Sugeridas</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="fra-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción" maxlength="60">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button data-tipo="fra" type="button" class="btn btn-sm btn-primary btnSaveDig"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-fra" class="table table-striped jambo_table">
                          <thead>
                            <th>Descripción</th>
                            <th>
                              <?php if($edita) : ?>
                              <button data-tipo="fra" type="button" class="btn btn-xs btn-default btnAddDig"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Beneficios del producto o servicio</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                              <input type="text" id="ben-desc" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="beneficio" placeholder="Descripción" maxlength="300">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button data-tipo="ben" type="button" class="btn btn-sm btn-primary btnSaveDig"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-ben" class="table table-striped jambo_table">
                          <thead>
                            <th>Descripción</th>
                            <th>
                              <?php if($edita) : ?>
                              <button data-tipo="ben" type="button" class="btn btn-xs btn-default btnAddDig"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <span class="section">Redes Sociales</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-4 col-sm-10 col-xs-12">
                              <input type="text" id="red-nom" class="form-control col-md-7 col-xs-12 input-sm precarga" data-pre="redsocial" placeholder="Nombre Red Social" maxlength="40">
                            </div>
                            <div class="col-md-6 col-sm-10 col-xs-12">
                              <input type="text" id="red-link" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Link de Página o Perfil" maxlength="80">
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <button type="button" class="btn btn-sm btn-primary" id="btnSaveRedS"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-redsol" class="table table-striped jambo_table">
                          <thead>
                            <th>Nombre</th>
                            <th>URL</th>
                            <th>
                              <?php if($edita) : ?>
                              <button type="button" class="btn btn-xs btn-default" id="btnAddRedS"><i class="fa fa-plus"></i></button>
                              <?php endif; ?>
                            </th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                      <!--div class="col-md-8 col-sm-8 col-xs-12">
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
                      </div-->
                    </div>

                    <div class="actionBar">
                      <button type="button" class="btn btn-default btnNext" data-next="4"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-default btnNext" data-next="6">Siguiente <i class="fa fa-angle-double-right"></i></button>
                      <!--button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="2"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-sm btn-round btn-default btnNextC" data-next="4">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                    </div>