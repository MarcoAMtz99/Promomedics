<?php 
  $titulo = "Escolaridad";
  // include 'header.php'; 
    include 'index2.php'; 

  $aperm = $_SESSION['perm'];
  $perm = $aperm[MOD_PRECARGAS];
  if(!array_key_exists(MOD_ESCOLARIDAD, $perm['children'])){
    include '403.php';
    exit(0);
  }else{
    $perm = $perm['children'][MOD_ESCOLARIDAD];
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
        <div class="container" >

          <div class="">

              <div class="">
                <div class="">
                  <div class="">
                    <h2>Escolaridad <small>Catálogo de Escolaridad</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <?php if($perm == 'EDIT') : ?>
                      <li>
                          <a id="btnAdd" class="add-link" data-toggle="modal" data-target="#frm-item">
                              <i class="fa fa-plus"></i> Agregar
                          </a>
                      </li>
                      <?php endif; ?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">

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
                  <h4 class="modal-title">Agregar Escolaridad</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item-nom">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="item-nom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Nombre del nivel de escolaridad">
                      </div>
                    </div>
                    <div class="form-group">
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
                          <h4 class="modal-title" id="myModalLabel">Eliminar Escolaridad</h4>
                      </div>
                      <div class="modal-body">
                          <p>¿Estas seguro de eliminar el nivel '<strong></strong>'?</p>
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
        $('#mnu-pre').addClass('active');


        $('#btnAdd').click(function(event) {
          $('#frm-item .modal-title').html('Agregar Escolaridad');
          $('#frm-item input').val('');
          $('#item-id').val(0);
          $('#frm-item').hide();
        });

        getItems();

        $('body').on('click', '.btn-perm', function(){
            $('#tbl-items tr.info').removeClass('info');
            id = $(this).parent().data('id');
            mod = $(this).parents('tr').addClass('info').find('td:eq(0)').html();
            $('#modlbl').html(mod);
            getPermisos(id);
        });

        $('body').on('click', '.btn-edit', function(){
            id = $(this).parent().data('id');
            nom = $(this).parent().prev().prev().html();
            desc = $(this).parent().prev().html();
            $('#frm-item .modal-title').html('Editar Escolaridad');
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

            act = 'addEscolaridad';
            if(parseInt(data.id,10) > 0) act = 'editEscolaridad';
            NProgress.start();
            $.post('core/precargas.php', 
              {action: act, data: $.toJSON(data)}, 
              function(resp) {
                if(!resp.error){
                  $('#tbl-items').DataTable().destroy();
                  addItemRow(resp.item, resp.actions);
                  $('#item-id').val('0');
                  $('#frm-item').modal('hide');
                  btn.removeClass('disabled');
                  doTable('#tbl-items', 2);
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
                'core/precargas.php',
                {action: 'delEscolaridad', nom: nom, id: id},
                function(resp){
                  if(resp.res){
                    $('#tbl-items').DataTable().destroy();
                    trp.remove();
                    $('#frm-item-del').modal('hide');
                    btn.removeClass('disabled');
                    doTable('#tbl-items', 2);
                  }
                  NProgress.done();
                },'json');
        });
      });


      function getItems(){
        NProgress.start();
        $.post('core/precargas.php', 
          {action: 'getEscolaridades'}, 
          function(resp) {
            $('#tbl-items tbody').empty();
            if(resp.items.length > 0){
              $.each(resp.items, function(index, item){
                addItemRow(item, resp.actions);
              });
              $("[data-toggle='tooltip']").tooltip();
            }
            $('.btn-perm:eq(0)').trigger('click');
            doTable('#tbl-items', 2);
            NProgress.done();
        },'json');
      }

      function addItemRow(item, act){
        nuevo = true;
        tr = $('<tr></tr>');
        if($("#tbl-items [data-id='"+item.id_escolaridad+"']").length > 0){
          nuevo = false;
          tr = $("#tbl-items [data-id='"+item.id_escolaridad+"']").parents('tr');
          tr.empty();
        }

        tr.append('<td>'+item.nombre+'</td>');
        tr.append('<td>'+item.descripcion+'</td>');
        tr.append('<td data-id="'+item.id_escolaridad+'" class="text-center">'+act+'</td>');
        
        if(nuevo) $('#tbl-items').append(tr);
      }


    </script>
