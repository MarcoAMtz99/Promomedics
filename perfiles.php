<?php 
  $titulo = "Perfiles";
  include 'header.php'; 

  $aperm = $_SESSION['perm'];
  $perm = $aperm[MOD_SEGURIDAD];
  if(!array_key_exists(MOD_PERFILES, $perm['children'])){
    include '403.php';
    exit(0);
  }else{
    $perm = $perm['children'][MOD_PERFILES];
    $perm = $perm['action'];
  }

?>
    
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">


    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">


        <!-- page content -->
        <div class="right_col" role="main">


          <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Perfiles <small>Tipos de usuarios del sistema</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="row">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <span class="section">Perfiles 
                          <?php if($perm == 'EDIT') : ?>
                          <button id="btnAdd" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#frm-item"><i class="fa fa-plus"></i> Agregar</button>
                          <?php endif; ?>
                        </span>

                        <table id="tbl-items" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Descripción</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <span class="section">Permisos de <small id="modlbl">Seguridad</small></span>
                        <input type="hidden" id="perf-id">
                        <table id="tbl-perm" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Módulo</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            <?php 
                              $SQLm = "SELECT m.id_modulo, m.fk_parent, 
                                            (SELECT CASE fk_parent WHEN 0 THEN m.nombre ELSE CONCAT((SELECT nombre FROM seg_modulo WHERE id_modulo = m.fk_parent),' / ', m.nombre) END) AS nombre, 
                                            (SELECT CASE fk_parent WHEN 0 THEN m.icono ELSE (SELECT icono FROM seg_modulo WHERE id_modulo = m.fk_parent) END) AS icono
                                          FROM seg_modulo m WHERE m.status = 1 AND m.url != '#'
                                            ORDER BY id_modulo, fk_parent; ";
                              $resm = mysqli_query($conn,$SQLm);

                              while ($mod = mysqli_fetch_assoc($resm)) {
                                echo "<tr>";
                                echo "<td><i class='fa fa-".$mod['icono']."'></i> ".$mod['nombre']."</td>";
                                echo "<td data-mod='".$mod['id_modulo']."' data-par='".$mod['fk_parent']."'>";

                                if($perm == 'EDIT') : 
                                ?>
                                  <div id="item-perm<?php echo $mod['id_modulo']; ?>" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-xs btn-default">
                                      <input type="radio" name="item-perm<?php echo $mod['id_modulo'] ?>" value="VIEW"> &nbsp; VER &nbsp;
                                    </label>
                                    <label class="btn btn-xs btn-default">
                                      <input type="radio" name="item-perm<?php echo $mod['id_modulo'] ?>" value="EDIT"> EDITAR
                                    </label>
                                    <label class="btn btn-xs btn-default">
                                      <input type="radio" name="item-perm<?php echo $mod['id_modulo'] ?>" value="NONE"> NADA
                                    </label>
                                  </div>
                                <?php
                                else:
                                  echo "<span id='item-perm".$mod['id_modulo'].">NADA</span>";
                                endif;
                                echo "</td>";
                                echo "</tr>";
                              }
                            ?>

                          </tbody>
                        </table>
                      </div>

                    </div>
                    
                  </div>
                </div>
              </div>
            </div>

          <div class="clearfix"></div>

          <?php if($perm == 'EDIT') : ?>
          <div id="frm-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Agregar Perfil</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal form-label-left">

                    <div class="form-group">
                       <div class="clearfix"></div>
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item-nom">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Perfil">
                      </div>
                    </div>
                    <div class="form-group">
                       <div class="clearfix"></div>
                      <label for="item-desc" class="control-label col-md-3 col-sm-3 col-xs-12">Descripción</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-desc" class="form-control col-md-7 col-xs-12" type="text" placeholder="Descripción">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <input type="hidden" id="item-id" value="0">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button id="btnSave" type="button" class="btn btn-primary">Guardar</button>
                </div>

              </div>
            </div>
          </div>


          <div class="modal fade" id="frm-item-del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">Eliminar Perfil</h4>
                      </div>
                      <div class="modal-body">
                          <p>¿Estas seguro de eliminar el perfil '<strong></strong>'?</p>
                          <input type="hidden" id="item-del-id" value="0">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnDelete">Eliminar</button>
                      </div>
                  </div>
              </div>
          </div>
          <?php endif; ?>
          
        </div>
        <!-- /page content -->

        <?php include 'footer.php'; ?>


    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>



    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>

    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <!-- jQuery Smart Wizard >
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script-->
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- validator -->
    <script src="vendors/validator/validator.js"></script>
    

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

    <script>
      $(document).ready(function() {
        $('body').removeClass('nav-sm').addClass('nav-md');
        $('#mnu-seg').addClass('active');


        $('#btnAdd').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Perfil');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          $('#frm-item').hide();
        });

        getPerfiles();

        $('body').on('click', '.btn-perm', function(){
            $('#tbl-items tr.info').removeClass('info');
            id = $(this).parent().data('id');
            mod = $(this).parents('tr').addClass('info').find('td:eq(0)').html();
            $('#modlbl').html(mod);
            $('#perf-id').val(id);
            getPermisos(id);
        });

        $('body').on('click', '.btn-edit', function(){
            id = $(this).parent().data('id');
            nom = $(this).parent().prev().prev().html();
            desc = $(this).parent().prev().html();
            $('#frm-item .modal-title').html('Editar Perfil');
            $('#item-nom').val(nom);
            $('#item-desc').val(desc);

            $('#item-id').val(id);
            $('#frm-item').modal('show');
        });

        $('#btnSave').click(function() {
          data = {
              id: parseInt($('#item-id').val(),10), 
              nom: $.trim($('#item-nom').val()),
              desc: $.trim($('#item-desc').val())
              };

          if(data.nom.length < 3){
            setError('item-nom', 'Debe ingresar un nombre');
          }else{
            btn = $(this);
            btn.addClass('disabled');

            act = 'addPerfil';
            if(parseInt(data.id,10) > 0) act = 'editPerfil';
            NProgress.start();
            $.post('core/seguridad.php', 
              {action: act, data: $.toJSON(data)}, 
              function(resp) {
                if(!resp.error){
                  addItemRow(resp.item, resp.actions);
                  $('#item-id').val('0');
                  $('#frm-item').modal('hide');
                  btn.removeClass('disabled');
                }else{
                  setError('btnSave', resp.msg);
                  btn.removeClass('disabled');
                }
                NProgress.done();
            },'json');
          }
        });

        $('body').on('click', '.btn-del', function(){
            trp = $(this).parents('tr');
            id = $(this).parent().data('id');
            nombre = trp.find('td:eq(0)').html();
            $('#item-del-id').val(id);
            $('#frm-item-del').find('strong:eq(0)').html(nombre);
            $('#frm-item-del').modal('show');
        });

        $('#btnDelete').click(function() {
            id = $('#item-del-id').val();
            trp = $("[data-id='"+id+"']").parent();
            nom = trp.find('td:eq(0)').html();
            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                'core/seguridad.php',
                {action: 'delPerfil', nom: nom, id: id},
                function(resp){
                  if(resp.res){
                    trp.remove();
                    $('#frm-item-del').modal('hide');
                    btn.removeClass('disabled');
                  }
                  NProgress.done();
                },'json');
        });

        $('#tbl-perm label').click(function() {
          data = {
                perf: $('#perf-id').val(),
                mod: $(this).parents('td').data('mod'),
                par: $(this).parents('td').data('par'),
                act: $(this).find('input').val()
              }
          if(!$(this).hasClass('active')){
            NProgress.start();
            $.post('core/seguridad.php', 
              {action: 'savePerm', data: $.toJSON(data)}, 
              function(resp) {
                NProgress.done();
            });
          }
        });
      });


      function getPerfiles(){
        NProgress.start();
        $.post('core/seguridad.php', 
          {action: 'getPerfiles'}, 
          function(resp) {
            $('#tbl-items tbody').empty();
            if(resp.items.length > 0){
              $.each(resp.items, function(index, item){
                addItemRow(item, resp.actions);
              });
              $("[data-toggle='tooltip']").tooltip();
            }
            $('.btn-perm:eq(0)').trigger('click');
            NProgress.done();
        },'json');
      }

      function addItemRow(item, act){
        nuevo = true;
        tr = $('<tr></tr>');
        if($("#tbl-items [data-id='"+item.id_perfil+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-items [data-id='"+item.id_perfil+"']").parents('tr');
          tr.empty();
        }

        sub = '<button class="btn btn-default btn-xs btn-perm" data-toggle="tooltip" title="Permisos"><i class="fa fa-check-square fa-fw"></i></button> ';

        tr.append('<td>'+item.nombre+'</td>');
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td data-id="'+item.id_perfil+'" class="text-center">'+sub+act+'</td>');
        
        if(nuevo) $('#tbl-items').append(tr);
      }

      function getPermisos(perf){
        NProgress.start();
        $('#tbl-perm .active').removeClass('active');
        $('#tbl-perm [value="NONE"]').parent().addClass('active');

        $.post('core/seguridad.php', 
          {action: 'getPermisos', perf: perf}, 
          function(resp) {
            $.each(resp.items, function(index, item) {
              if(resp.action == 'EDIT'){
                $("#item-perm"+item.fk_modulo+" [value='NONE']").parent().removeClass('active');
                $("#item-perm"+item.fk_modulo+" [value='"+item.action+"']").parent().addClass('active');
              }else{
                act = 'VER';
                if(item.action == 'EDIT') act = 'EDITAR';
                $("#item-perm"+item.fk_modulo).html(act);
              }
            });
            NProgress.done();
        },'json');
      }


    </script>
