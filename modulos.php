<?php 
  $titulo = "Módulos";
  include 'header.php'; 

  $aperm = $_SESSION['perm'];
  $perm = $aperm[MOD_SEGURIDAD];
  if(!array_key_exists(MOD_MODULOS, $perm['children'])){
    include '403.php';
    exit(0);
  }else{
    $perm = $perm['children'][MOD_MODULOS];
    $perm = $perm['action'];
  }

?>

    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">


    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">

        <!-- page content -->
        <div class="right_col" role="main">


          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Módulos <small>Menús de primer nivel</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li><a id="btnAddM" class="add-link"><i class="fa fa-plus"></i> Agregar Módulo</a></li>
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                      <table id="tbl-items" class="table table-striped table-bordered table-condensed">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>URL</th>
                            <th>ID</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
          </div>

          <div id="div-subm" class="row hide">
            <input type="hidden" id="sub-parent" value="0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Submódulos <small>Submenús de </small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li><a id="btnAddS" class="add-link"><i class="fa fa-plus"></i> Agregar Submódulo</a></li>
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                      <table id="tbl-subm" class="table table-striped table-bordered table-condensed">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>URL</th>
                            <th>ID</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
          </div>

          <?php if($perm == 'EDIT') : ?>
          <div id="frm-item" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Agregar Módulo</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item-nom">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Módulo">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-desc" class="control-label col-md-3 col-sm-3 col-xs-12">Descripción</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-desc" class="form-control col-md-7 col-xs-12" type="text" placeholder="Descripción">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="item-abrev" class="control-label col-md-3 col-sm-3 col-xs-12">Abrev <span class="required">*</span></label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="item-abrev" class="form-control col-md-7 col-xs-12" type="text" placeholder="Abreviación menú" maxlength="6">
                      </div>
                      <label for="item-ico" class="control-label col-md-1 col-sm-1 col-xs-12">Icono</label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="item-ico" class="form-control col-md-7 col-xs-12" type="text" placeholder="Icono de menú">
                      </div>
                    </div>


                    <div class="form-group item-tipo">
                      <label for="item-tipo" class="control-label col-md-3 col-sm-3 col-xs-12">Tipo</label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <select id="item-tipo" class="form-control">
                          <option value="1">Directo</option>
                          <option value="2">Menú</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group item-url">
                      <label for="item-url" class="control-label col-md-3 col-sm-3 col-xs-12">URL <span class="required">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-url" class="form-control col-md-7 col-xs-12" type="text" placeholder="URL">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <input type="hidden" id="item-parent" value="0">
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
                          <h4 class="modal-title" id="myModalLabel">Eliminar Módulo</h4>
                      </div>
                      <div class="modal-body">
                          <p>¿Estas seguro de eliminar '<strong></strong>' (<strong></strong>)?</p>
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
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

    <script>
      $(document).ready(function() {

        $('body').removeClass('nav-sm').addClass('nav-md');
        $('#mnu-seg').addClass('active');


        $('#btnAddM').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Módulo');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          $('#item-parent').val(0);
          $('#item-tipo').val(1);
          $('.item-tipo').removeClass('hide');
          $('.item-url').removeClass('hide');
          $('#frm-item').modal('show');
        });

        $('#item-tipo').change(function() {
          tipo = $(this).val();
          if(tipo == 1){
            $('.item-url').removeClass('hide');
            $('#item-url').val('');
          }else{
            $('.item-url').addClass('hide');
            $('#item-url').val('#');
          }
        });

        $('#btnAddS').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Submódulo');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          $('#item-parent').val($('#sub-parent').val());
          $('.item-tipo').addClass('hide');
          $('.item-url').removeClass('hide');
          $('#frm-item').modal('show');
        });

        getModulos();

        $('body').on('click', '.btn-subm', function(){
            id = $(this).parent().data('id');
            mod = $(this).parents('tr').find('td:eq(0)').html();
            $('#div-subm .x_title small').html('Submenús de '+mod);
            $('#sub-parent').val(id);
            getSubmodulos(id);
        });

        $('body').on('click', '.btn-edit', function(){
            id = $(this).parent().data('id');
            NProgress.start();
            $.post(
              'core/seguridad.php', {action: 'getModulo', id: id}, 
              function(resp) {
                if(!resp.error){
                  $('#frm-item .modal-title').html('Editar Módulo');
                  $('#item-nom').val(resp.item.nombre);
                  $('#item-desc').val(resp.item.descripcion);
                  $('#item-abrev').val(resp.item.abrev);
                  $('#item-ico').val(resp.item.icono);
                  tipo = 2;
                  if(resp.item.fk_parent != 0) tipo = 1;
                  $('#item-tipo').val(tipo).trigger('change');
                  $('#item-url').val(resp.item.url);

                  $('#item-id').val(id);
                  $('#item-parent').val(resp.item.fk_parent);
                  $('#frm-item').modal('show');
                  NProgress.done();
                }
            },'json');
        });

        $('body').on('click', '.btn-edits', function(){
            id = $(this).parent().data('id');
            NProgress.start();
            $.post(
              'core/seguridad.php', {action: 'getModulo', id: id}, 
              function(resp) {
                if(!resp.error){
                  $('#frm-item .modal-title').html('Editar Submódulo');
                  $('#item-nom').val(resp.item.nombre);
                  $('#item-desc').val(resp.item.descripcion);
                  $('#item-abrev').val(resp.item.abrev);
                  $('#item-ico').val(resp.item.icono);
                  $('#item-tipo').val(1);
                  $('.item-tipo').addClass('hide');
                  $('.item-url').removeClass('hide');
                  $('#item-url').val(resp.item.url);

                  $('#item-id').val(id);
                  $('#item-parent').val(resp.item.fk_parent);
                  $('#frm-item').modal('show');
                  NProgress.done();
                }
            },'json');
        });

        $('#btnSave').click(function() {
          data = {
              id: parseInt($('#item-id').val(),10), 
              parent: $('#item-parent').val()
              };
          $.each($('#frm-item input'), function(index, el) {
            id = $(el).attr('id');
            id = id.replace('item-','');
            data[id] = $.trim($(el).val());
          });

          if(data.nom.length < 3){
            setError('item-nom', 'Debe ingresar un nombre');
          }else if(data.abrev.length < 3){
            setError('item-abrev', 'Debe ingresar una abreviacion');
          }else if($('#item-tipo').val() == 1 && data.url.length < 3){
            setError('item-url', 'Debe ingresar una URL');
          }else{
            btn = $(this);
            btn.addClass('disabled');

            act = 'addModulo';
            if(parseInt(data.id,10) > 0) act = 'editModulo';
            NProgress.start();
            $.post('core/seguridad.php', 
              {action: act, data: $.toJSON(data)}, 
              function(resp) {
                if(!resp.error){
                  if(parseInt(data.parent,10) == 0){
                    $('#tbl-items').DataTable().destroy();
                    addItemRow(resp.item, resp.actions);
                    doTable('#tbl-items', 4);
                  }else{
                    $('#tbl-subm').DataTable().destroy();
                    addItemRowS(resp.item, resp.actions);
                    doTable('#tbl-subm', 4);
                  }

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
            url = trp.find('td:eq(2)').html();
            $('#item-del-id').val(id);
            $('#frm-item-del').find('strong:eq(0)').html(nombre);
            $('#frm-item-del').find('strong:eq(1)').html(url);
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
                {action: 'delModulo', nom: nom, id: id},
                function(resp){
                  if(resp.res){
                    $('#tbl-items').DataTable().destroy();
                    $('#tbl-subm').DataTable().destroy();
                    trp.remove();
                    $('#frm-item-del').modal('hide');
                    btn.removeClass('disabled');
                    doTable('#tbl-items', 6);
                    doTable('#tbl-subm', 6);
                  }
                  NProgress.done();
                },'json');
        });

      });

      function getModulos(){
        NProgress.start();
        $.post('core/seguridad.php', 
          {action: 'getModulos'}, 
          function(resp) {
            $('#tbl-items tbody').empty();
            if(resp.items.length > 0){
              $.each(resp.items, function(index, item){
                addItemRow(item, resp.actions);
              });
              $("[data-toggle='tooltip']").tooltip();
            }
            doTable('#tbl-items', 4);
            NProgress.done();
        },'json');
      }

      function addItemRow(item, act){
        nuevo = true;
        tr = $('<tr></tr>');
        if($("#tbl-items [data-id='"+item.id_modulo+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-items [data-id='"+item.id_modulo+"']").parents('tr');
          tr.empty();
        }

        sub = '';
        if(item.submodulos > 0){
          sub = '<button class="btn btn-default btn-xs btn-subm" data-toggle="tooltip" title="Submodulos"><i class="fa fa-th fa-fw"></i></button> ';
        }

        tr.append('<td>'+item.nombre+'</td>');
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+item.url+'</td>');
        tr.append('<td>'+item.id_modulo+'</td>');
        tr.append('<td data-id="'+item.id_modulo+'" class="text-center">'+sub+act+'</td>');
        
        if(nuevo) $('#tbl-items').append(tr);
      }

      function getSubmodulos(mod){
        NProgress.start();
        $.post('core/seguridad.php', 
          {action: 'getSubmodulos', id: mod}, 
          function(resp) {
            $('#tbl-subm tbody').empty();
            $('#div-subm').removeClass('hide');
            $('#tbl-subm').DataTable().destroy();
            if(resp.items.length > 0){
              $.each(resp.items, function(index, item){
                addItemRowS(item, resp.actions);
              });                
              $("[data-toggle='tooltip']").tooltip();
            }
            doTable('#tbl-subm', 4);
            NProgress.done();
        },'json');
      }

      function addItemRowS(item, act){
        nuevo = true;
        tr = $('<tr></tr>');
        if($("#tbl-subm [data-id='"+item.id_modulo+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-subm [data-id='"+item.id_modulo+"']").parents('tr');
          tr.empty();
        }

        tr.append('<td>'+item.nombre+'</td>');
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td>'+item.url+'</td>');
        tr.append('<td>'+item.id_modulo+'</td>');
        tr.append('<td data-id="'+item.id_modulo+'" class="text-center">'+act+'</td>');

        if(nuevo) $('#tbl-subm').append(tr);
      }


    </script>
