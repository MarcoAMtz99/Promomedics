                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <span class="section">Archivos</span>

                        <?php if($edita) : ?>
                        <form class="form-horizontal form-label-left hide" id="fileFrm">
                          <div class="form-group">
                            <label for="file-name" class="control-label col-md-1 col-sm-1 col-xs-12">Archivo</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <div class="input-group">
                                <input type="text" id="file-name" name="file-name" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Seleccionar archivo .jpg, .png, pdf, docx, pptx, xlsx">
                                <input id="file-file" name="file-file" type="file" style="display:none">
                                <span class="input-group-btn">
                                  <button id="file-busca" class="btn btn-sm btn-default" type="button">Buscar..</button>
                                </span>
                              </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                              <input type="text" id="file-camp" name="file-camp" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Campaña">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" id="file-desc" name="file-desc" class="form-control col-md-7 col-xs-12 input-sm" placeholder="Descripción">
                            </div>
                            <div class="col-md-1 col-sm-1 col-xs-12 text-right">
                              <input type="hidden" name="action" id="action" value="addFile">
                              <input type="hidden" name="file-ext" id="file-ext" value="">
                              <input type="hidden" name="file-peso" id="file-peso" value="">
                              <input type="hidden" name="file-med" id="file-med" value="<?= $med ?>">
                              <button id="btnSaveFile" type="button" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            </div>
                          </div>
                        </form>
                        <?php endif; ?>

                        <table id="tbl-file" class="table table-striped jambo_table">
                          <thead>
                              <th>Nombre del archivo</th>
                              <th>Campaña</th>
                              <th>Descripción</th>
                              <th>Subido</th>
                              <th>Tipo</th>
                              <th>Peso</th>
                              <th>
                                <?php if($edita) : ?>
                                <button id="btnAddFile" type="button" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button>
                                <?php endif; ?>
                              </th>
                            </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="actionBar">
                      
                      <button type="button" class="btn btn-default btnNext" data-next="<?php echo $infoMed['medios_digitales'] == 1 ? '5' : '4' ?>"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <button type="button" class="btn btn-default btnNext" data-next="<?php echo $infoMed['medios_digitales'] == 1 ? '7' : '6' ?>">Siguiente <i class="fa fa-angle-double-right"></i></button>
                    </div>