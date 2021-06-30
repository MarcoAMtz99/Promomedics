                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="section">Idiomas</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide">
                          <div class="form-group">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input type="text" class="form-control has-feedback-left" id="idi-idi" placeholder="Idioma">
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