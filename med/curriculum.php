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