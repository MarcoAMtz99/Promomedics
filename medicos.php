<?php 
  $titulo = "Médicos";
  include 'header.php'; 

  $aperm = $_SESSION['perm'];
  if(!array_key_exists(MOD_MEDICOS, $aperm)){
    include '403.php';
    exit(0);
  }else{
    $perm = $aperm[MOD_MEDICOS];
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
    <!-- Select2 >
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet"-->


    <!-- Custom Theme Style >
    <link href="build/css/custom.min.css" rel="stylesheet"-->



        <!-- page content -->
        <div class="right_col" role="main">


          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Alta de Médicos <small>Medicos registrados</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li><a id="btnAdd" class="add-link"><i class="fa fa-plus"></i> Agregar Médico</a></li>
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                      <table id="tbl-items" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Nombre Médico</th>
                            <th>Especialidad</th>
                            <th>Cédula</th>
                            <th>Email</th>
                            <th>Acceso</th>
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
          <div id="frm-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title">Agregar </h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item-nom">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Médico">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-ape" class="control-label col-md-3 col-sm-3 col-xs-12">Paterno</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-ape" class="form-control col-md-7 col-xs-12" type="text" placeholder="Apellido Paterno">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-mat" class="control-label col-md-3 col-sm-3 col-xs-12">Materno</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-mat" class="form-control col-md-7 col-xs-12" type="text" placeholder="Apellido Materno">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="item-ced" class="control-label col-md-3 col-sm-3 col-xs-12">Cédula <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="item-ced" class="form-control col-md-7 col-xs-12" type="text" placeholder="Número Cédula" <?php echo $usertype != 1 ? 'disabled' : '' ?>>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="item-mail" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-mail" class="form-control col-md-7 col-xs-12" type="text" placeholder="Correo electrónico">
                      </div>
                    </div>
                    
                    <hr class="creado">
                    <div class="form-group creado">
                      <label for="item-creado" class="control-label col-md-3 col-sm-3 col-xs-12">Creado</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-creado" class="form-control col-md-7 col-xs-12" type="text" readonly>
                      </div>
                    </div>
                    
                  </form>
                </div>
                <div class="modal-footer">
                  <input type="hidden" id="item-id" value="0">
                  <input type="hidden" id="item-med" value="0">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <a href="#" id="btnDatos" class="btn btn-default hide">Ver todos los datos</a>
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
                          <h4 class="modal-title" id="myModalLabel">Eliminar Médico</h4>
                      </div>
                      <div class="modal-body">
                          <p>¿Estas seguro de eliminar a '<strong></strong>' (<strong></strong>)?</p>
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

	<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>


    
    

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>


    <script>
      $(document).ready(function() {

        $('#mnu-med').addClass('active');


        $('#btnAdd').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Médico');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          $('#item-med').val(0);
          $('#btnDatos').addClass('hide').attr('href', '#');
          $('.creado').addClass('hide');
          //$('#item-perf').val(1);
          $('#frm-item small').addClass('hide');
          $('#frm-item').modal('show');
        });

        getMedicos();

        $('body').on('click', '.btn-edit', function(){
            id = $(this).parent().data('id');
            NProgress.start();
            $.post(
              'core/medicos/getMedico', {id: id}, 
              function(resp) {
                if(!resp.error){
                  $('#frm-item .modal-title').html('Editar Médico');
                  $('#item-nom').val(resp.item.nombre);
                  $('#item-ape').val(resp.item.paterno);
                  $('#item-mat').val(resp.item.materno);
                  $('#item-mail').val(resp.item.email);
                  $('#item-ced').val(resp.item.num_cedula);

                  $('#btnDatos').removeClass('hide').attr('href', '/medico/'+resp.item.fk_medico);

                  $('.creado').removeClass('hide');
                  $('#item-creado').val(resp.item.creado+' por '+resp.item.usuario);

                  $('#item-id').val(id);
                  $('#item-med').val(resp.item.fk_medico);
                  $('#frm-item small').removeClass('hide');
                  $('#frm-item').modal('show');
                  NProgress.done();
                }
            },'json');
        });

        /*$('body').on('click', '.btn-edit', function(){
            med = $(this).parent().data('idm');
            window.location.href = '/medico/'+med;
        });*/

        $('#btnSave').click(function() {
          data = {
              id: parseInt($('#item-id').val(),10), 
              perf: $('#item-perf').val()
              };
          $.each($('#frm-item input'), function(index, el) {
            id = $(el).attr('id');
            id = id.replace('item-','');
            data[id] = $.trim($(el).val());
          });
          var filterMail = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

          if(data.nom.length < 3){
            setError('item-nom', 'Debe ingresar un nombre');
          }/*else if(data.user.length < 3){
            setError('item-user', 'Debe ingresar un username');
          }*/else if(data.mail.length < 3){
            setError('item-mail', 'Debe ingresar un correo electrónico');
          }else if(!filterMail.test(data.mail)){
            setError('item-mail','Debes ingresar un email válido');
          }else{
            btn = $(this);
            btn.addClass('disabled');

            act = 'addMedico';
            if(parseInt(data.id,10) > 0) act = 'editMedico';
            NProgress.start();
            $.post('core/medicos/'+act, 
              {data: $.toJSON(data)}, 
              function(resp) {
                if(!resp.error){
                  $('#tbl-items').DataTable().destroy();
                  addItemRow(resp.item, resp.actions);
                  doTable('#tbl-items', 5);
                  $('#item-id').val('0');
                  $('#frm-item').modal('hide');
                  btn.removeClass('disabled');
                }else{
                  setError(resp.elem, resp.msg);
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
            ced = trp.find('td:eq(1)').html();
            $('#item-del-id').val(id);
            $('#frm-item-del').find('strong:eq(0)').html(nombre);
            $('#frm-item-del').find('strong:eq(1)').html(ced);
            $('#frm-item-del').modal('show');
        });

        $('#btnDelete').click(function() {
            id = $('#item-del-id').val();
            trp = $("[data-id='"+id+"']").parent();
            user = trp.find('td:eq(1)').html();
            btn = $(this);
            btn.addClass('disabled');
            NProgress.start();
            $.post(
                'core/medicos/delMedico',
                {nom: user, id: id},
                function(resp){
                  if(resp.res){
                    $('#tbl-items').DataTable().destroy();
                    trp.remove();
                    $('#frm-item-del').modal('hide');
                    btn.removeClass('disabled');
                    doTable('#tbl-items', 5);
                  }
                  NProgress.done();
                },'json');
        });

        $('body').on('click', '.btn-act', function(){
            id = $(this).parent().data('id');
            td = $(this).parent();
            NProgress.start();
            $.post(
              'core/medicos/activaMedico', {id: id}, 
              function(resp) {
                if(!resp.error){
                  alerta = $('<div class="alert alert-success">Se activo al médico correctamente</div>');
                  $('#tbl-items').before(alerta);
                  setTimeout(function(){ alerta.remove(); }, 5000);
                  td.find('.btn-rea').remove();
                  td.find('.btn-act').remove();
                  $('.tooltip').remove();
                  NProgress.done();
                }
            },'json');
        });

        $('body').on('click', '.btn-rea', function(){
            id = $(this).parent().data('id');
            td = $(this).parent();
            btn = $(this);
            NProgress.start();
            $.post(
              'core/medicos/reactivaMedico', {id: id}, 
              function(resp) {
                if(!resp.error){
                  alerta = $('<div class="alert alert-success">Se envio la nueva contraseña por correo al médico</div>');
                  $('#tbl-items').before(alerta);
                  setTimeout(function(){ alerta.remove(); }, 5000);

                  if(td.find('.btn-act').length == 0) btn.before(resp.act);
                  if(td.find('.btn-neg').length == 0) btn.before(resp.neg);
                  $('.tooltip').remove();

                  NProgress.done();
                }
            },'json');
        });

        $('body').on('click', '.btn-neg', function(){
            id = $(this).parent().data('id');
            td = $(this).parent();
            btn = $(this);
            NProgress.start();
            $.post(
              'core/medicos/rechazaMedico', {id: id}, 
              function(resp) {
                if(!resp.error){
                  alerta = $('<div class="alert alert-success">Se marco al médico como No Autorizado</div>');
                  $('#tbl-items').before(alerta);
                  setTimeout(function(){ alerta.remove(); }, 5000);

                  if(td.find('.btn-rea').length == 0) btn.before(resp.neg);
                  td.find('.btn-act').remove();
                  td.find('.btn-neg').remove();

                  $('.tooltip').remove();

                  NProgress.done();
                }
            },'json');
        });

      });

      function getMedicos(){
        NProgress.start();
        $.post('core/medicos/getMedicos', 
          {}, 
          function(resp) {
            $('#tbl-items tbody').empty();
            if(resp.items.length > 0){
              $.each(resp.items, function(index, item){
                addItemRow(item, resp.actions);
              });
              $("[data-toggle='tooltip']").tooltip();
            }
            doTable('#tbl-items', 5);
            NProgress.done();
        },'json');
      }

      function addItemRow(item, act){
        nuevo = true;
        tr = $('<tr></tr>');
        if($("#tbl-items [data-id='"+item.id_user+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-items [data-id='"+item.id_user+"']").parents('tr');
          tr.empty();
        }

        tr.append('<td>'+item.nombre+'</td>');
        tr.append('<td>'+item.especialidad+'</td>');
        tr.append('<td>'+item.num_cedula+'</td>');
        tr.append('<td>'+item.email+'</td>');
        tr.append('<td>'+item.acceso+'</td>');
        tda = $('<td data-idm="'+item.ID+'" data-id="'+item.id_user+'" class="text-center">'+act+'</td>');
        $(tda).find('.btn-edit').after(item.act);
        $(tda).find('.btn-del').before(item.neg);
        $(tda).find('.btn-del').before(item.rea);
        tr.append(tda);
        
        if(nuevo) $('#tbl-items').append(tr);
      }


    </script>