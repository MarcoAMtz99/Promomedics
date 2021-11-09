<?php 
  $titulo = "Usuarios";
  // include 'header.php'; 
    include 'index2.php'; 

  $aperm = $_SESSION['perm'];
  $perm = $aperm[MOD_SEGURIDAD];
  if(!array_key_exists(MOD_USUARIOS, $perm['children'])){
    include '403.php';
    exit(0);
  }else{
    $perm = $perm['children'][MOD_USUARIOS];
    $perm = $perm['action'];
  }

?>

    <!-- iCheck -->
    <link href="<?php echo URL_ROOT; ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo URL_ROOT; ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="<?php echo URL_ROOT; ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_ROOT; ?>/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    
    <link href="<?php echo URL_ROOT; ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
     
    <link href="<?php echo URL_ROOT; ?>/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- page content -->
        <div class="right_col" role="main">

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Usuarios <small>Usuarios con acceso al sistema</small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li>
                            <a id="btnAdd" class="add-link" data-toggle="modal" data-target="#frm-item">
                                <i class="fa fa-plus"></i>
                                Agregar Usuario
                            </a>
                        </li>
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
                            <th>Nombre</th>
                            <!--th>Usuario</th-->
                            <th>Email</th>
                            <th>Acceso</th>
                            <th>Perfil</th>
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
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del Usuario">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="item-ape" class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-ape" class="form-control col-md-7 col-xs-12" type="text" placeholder="Apellidos">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="item-mail" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="item-mail" class="form-control col-md-7 col-xs-12" type="text" placeholder="Correo electrónico">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="item-perf" class="control-label col-md-3 col-sm-3 col-xs-12">Perfil</label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <select id="item-perf" class="form-control">
                          <?php 
                            $limitados = "";
                            if($usertype == 4) $limitados = "AND id_perfil > 3";
                            $SQLp = "SELECT id_perfil, nombre FROM seg_perfil WHERE status = 1 $limitados; ";
                            $resp = mysqli_query($conn,$SQLp);

                            while ($perf = mysqli_fetch_assoc($resp)) {
                              echo '<option value="'.$perf['id_perfil'].'">'.$perf['nombre'].'</option>' ;
                            }
                           ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group hide">
                      <label for="item-user" class="control-label col-md-3 col-sm-3 col-xs-12">Username <span class="required">*</span></label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="item-user" class="form-control col-md-7 col-xs-12" type="text" placeholder="Username">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="item-pass" class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña</label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <input id="item-pass" class="form-control col-md-7 col-xs-12" type="text" placeholder="Contraseña">
                        <small>Dejar vacío para no modificar</small>
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
                          <h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
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


        $('#btnAdd').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Usuario');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          //$('#item-perf').val(1);
          $('#frm-item small').addClass('hide');
          $('#frm-item').hide();
        });

        getUsuarios();

        $('body').on('click', '.btn-edit', function(){
            id = $(this).parent().data('id');
            NProgress.start();
            $.post(
              'core/seguridad.php', {action: 'getUsuario', id: id}, 
              function(resp) {
                if(!resp.error){
                  $('#frm-item .modal-title').html('Editar Usuario');
                  $('#item-nom').val(resp.item.nombre);
                  $('#item-ape').val(resp.item.apellidos);
                  $('#item-perf').val(resp.item.fk_perfil);
                  $('#item-mail').val(resp.item.email);
                  $('#item-user').val(resp.item.username);
                  $('#item-pass').val('');

                  $('#item-id').val(id);
                  $('#frm-item small').removeClass('hide');
                  $('#frm-item').modal('show');
                  NProgress.done();
                }
            },'json');
        });

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

            act = 'addUsuario';
            if(parseInt(data.id,10) > 0) act = 'editUsuario';
            NProgress.start();
            $.post('core/seguridad.php', 
              {action: act, data: $.toJSON(data)}, 
              function(resp) {
                if(!resp.error){
                  $('#tbl-items').DataTable().destroy();
                  addItemRow(resp.item, resp.actions);
                  doTable('#tbl-items', 4);
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
            user = trp.find('td:eq(2)').html();
            $('#item-del-id').val(id);
            $('#frm-item-del').find('strong:eq(0)').html(nombre);
            $('#frm-item-del').find('strong:eq(1)').html(user);
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
                'core/seguridad.php',
                {action: 'delUsuario', nom: user, id: id},
                function(resp){
                  if(resp.res){
                    $('#tbl-items').DataTable().destroy();
                    trp.remove();
                    $('#frm-item-del').modal('hide');
                    btn.removeClass('disabled');
                    doTable('#tbl-items', 4);
                  }
                  NProgress.done();
                },'json');
        });

      });

      function getUsuarios(){
        NProgress.start();
        $.post('core/seguridad.php', 
          {action: 'getUsuarios'}, 
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
        if($("#tbl-items [data-id='"+item.id_user+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-items [data-id='"+item.id_user+"']").parents('tr');
          tr.empty();
        }

        perf = $('#item-perf [value="'+item.fk_perfil+'"]').text();

        tr.append('<td>'+item.nombre+'</td>');
        //tr.append('<td>'+item.username+'</td>');
        tr.append('<td>'+item.email+'</td>');
        tr.append('<td>'+item.acceso+'</td>');
        tr.append('<td>'+perf+'</td>');
        tr.append('<td data-id="'+item.id_user+'" class="text-center">'+act+'</td>');
        
        if(nuevo) $('#tbl-items').append(tr);
      }


    </script>
