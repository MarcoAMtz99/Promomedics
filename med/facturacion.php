                    <?php 
                      $ant = 6;
                      if($infoMed['medios_digitales'] == 0 || $infoMed['archivos'] == 0) $ant = 5;
                      if($infoMed['medios_digitales'] == 0 && $infoMed['archivos'] == 0) $ant = 4;
                    ?>

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
                            <div class="control-label col-md-3 col-sm-3 col-xs-12"></div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <select class="form-control" id="fact-tipo">
                                <option value="1">Persona Física</option>
                                <option value="2">Persona Moral</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group persmoral">
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
                          <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="fact-mail">Email</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                              <input type="text" id="fact-mail" class="form-control col-md-7 col-xs-12" placeholder="Correo electrónico" value="<?= $infoFact['email'] ?>">
                            </div>
                          </div>

                        </form>
                        <input type="hidden" id="fact-id" value="<?= $infoMed['fact'] ?>">
                      </div>
                    </div>

                    <div class="actionBar">
                      <?php if($edita) : ?>
                      <button type="button" class="btn btn-primary hide" id="btnSaveFact"><i class="fa fa-check"></i> Guardar Datos Fiscales</button>
                      <?php endif; ?>
                      <button type="button" class="btn btn-default btnNext" data-next="<?php echo $ant ?>"><i class="fa fa-angle-double-left"></i> Anterior</button>
                      <!--button type="button" class="btn btn-default btnNext" data-next="6">Siguiente <i class="fa fa-angle-double-right"></i></button-->
                    </div>