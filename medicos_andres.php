    <?php 
      $titulo = "Médicos";
      include 'header.php'; 

      $aperm = $_SESSION['perm'];
      if(!array_key_exists(MOD_MEDICOS, $aperm)){
        include '403.php';
        exit(0);
      }

    ?>

	<?php 
		if(isset($_GET['id'])){
		$ID = $_GET['id'];
		$SQL = "SELECT * FROM seg_user WHERE id_user = $ID; ";
		$res = mysql_query($SQL);
		$infoMed = mysql_fetch_assoc($res);
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

          
					<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Alta de Medico <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
						<tr>
							<th>&emsp;ID Usuario&emsp;</th>
							<th>&emsp;NOMBRE&emsp;</th>
							<th>&emsp;APELLIDOS&emsp;</th>
							<th>&emsp;EMAIL&emsp;</th>
						</tr>
					  </thead>
					  <tbody>
						<?php 
							$SQL = "SELECT *, 
							(SELECT email FROM seg_user WHERE fk_medico = ID LIMIT 1) as email, 
							(SELECT id_user FROM seg_user WHERE fk_medico = ID LIMIT 1) as id_user 
							FROM medico
							 WHERE (SELECT COUNT(*) FROM seg_user WHERE fk_medico = ID) > 0; ";
              //$SQL = "SELECT * FROM seg_user";
							$res = mysql_query($SQL);
              print_r($res);
							while ($med = mysql_fetch_assoc($res)) {
								echo '<tr>';
								echo '<td> <a href="medicos.php?id='.$med['id_user'].'" target="_self"> '.$med['id_user'].' </a> </td>';
								echo '<td> <a href="medicos.php?id='.$med['id_user'].'" target="_self"> '.$med['nombre'].' </a> </td>';
								echo '<td> <a href="medicos.php?id='.$med['id_user'].'" target="_self"> '.$med['apellidos'].' </a> </td>';
								echo '<td> <a href="medicos.php?id='.$med['id_user'].'" target="_self"> '.$med['email'].' </a> </td>';
								echo '</tr>';}
						?>
					  </tbody>
                    </table>
                  </div>
				  
				  <!-- Fin de la tabla, inicio de captura de datos -->
				  
				  <div class="x_title">
                    <h2>Alta de Medico <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
					 
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <br />
                    <form method="POST" action="inputcreation.php" class="form-horizontal form-label-left input_mask">
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php
						if(isset($_GET['id'])){
						$id = $_GET['id'];
						$SQLC = "SELECT * FROM seg_user WHERE id_user = $id";
						$resC = mysql_query($SQLC);
						$con = mysql_fetch_assoc($resC);
						echo '<input type="text" class="form-control has-feedback-left" id="inputID" value="'.$con['id_user'].'" disabled/>';
						echo '<input type="hidden" name="inputID" value="'.$con['id_user'].'"/>';
						}
						else
						echo '<input type="text" class="form-control has-feedback-left" id="inputID" name="inputID" placeholder="ID" disabled>';
						?>
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php
						if(isset($_GET['id'])){
						echo '<input type="text" class="form-control" id="inputName" name="inputName" value="'.$con['nombre'].'"/>';
						}
						else
						echo '<input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nombre">';
						?>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<?php
						if(isset($_GET['id'])){
						echo '<input type="text" class="form-control has-feedback-left" id="inputLast" name="inputLast" value="'.$con['apellidos'].'"/>';
						}
						else
						echo '<input type="text" class="form-control has-feedback-left" id="inputLast" name="inputLast" placeholder="Apellidos">';
						?>                        
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<?php
						if(isset($_GET['id'])){
						echo '<input type="text" class="form-control" id="inputEmail" name="inputEmail" value="'.$con['email'].'"/>';
						}
						else
						echo '<input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">';
						?>   
                        
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php
						if(isset($_GET['id'])){
						echo '<input type="text" class="form-control has-feedback-left" id="inputCedula" name="inputCedula" placeholder="Cedula No Disponible" disabled>';
						}
						else
						echo '<input type="text" class="form-control has-feedback-left" id="inputCedula" name="inputCedula" placeholder="Cedula">';
						?>     
                        <span class="fa fa-university form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<?php
						if(isset($_GET['id'])){
						echo '<input type="text" class="form-control" id="inputTel" name="inputTel" placeholder="Telefono No Disponible" disabled/>';
						}
						else
						echo '<input type="text" class="form-control" id="inputTel" name="inputTel" placeholder="Telefono">';
						?>
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                      </div>
					  
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
						  <br />
						  <button class="btn btn-primary" id="btnLogin" type="submit" name="create" onclick="new /*TabbedNotification*/({
                                  title: 'Creación de Usuario',
                                  text: 'Usuario creado exitosamente!',
                                  type: 'info',
                                  sound: false
                              })">Crear</button>

                  <button class="btn btn-success" id="btnLogin" type="submit" name="activate" onclick="new ({
                                  title: 'Activación de Usuario',
                                  text: 'Usuario activado exitosamente!',
                                  type: 'success',
                                  sound: false
                              })">Activar</button>

                  <button class="btn btn-danger" id="btnLogin" type="submit" name="deny" onclick="new ({
                                  title: 'Cancelación de Usuario',
                                  text: 'Usuario negado exitosamente... :C',
                                  type: 'danger',
                                  sound: false
                              })">Negar</button>

                  <button class="btn btn-info" id="btnLogin" type="submit" name="reactivate" onclick="new ({
                                  title: 'Reactivación de Usuario',
                                  text: 'Usuario reactivado exitosamente!',
                                  type: 'info',
                                  sound: false
                              })">Re-activar</button>
							  
                  <button class="btn btn-warning" id="btnLogin" type="submit" name="modify" value="1" onclick="new ({
                                  title: 'Modificación de Usuario',
                                  text: 'Usuario modificado exitosamente!',
                                  type: 'warning',
                                  sound: false
                              })">Modificar</button>
                        </div>
                      </div>

                    </form>
                  </div> 
				  
				  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
					<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
					
					<div id="custom_notifications" class="custom-notifications dsp_none">
					  <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
					  </ul>
					  <div class="clearfix"></div>
					  <div id="notif-group" class="tabbed_notifications"></div>
					</div>
					
					</div> 
					
				  </div> 
					
                </div>
              </div>


          
        </div>
        <!-- /page content -->

        <?php include 'footer.php'; ?>


    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>

	<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>


    
    

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

    <script>
      $(document).ready(function() {

        $('#mnu-med').addClass('active');

        
      });


    </script>

	
	<!-- Custom Notification -->
    <script>
      $(document).ready(function() {
        var cnt = 10;

        TabbedNotification = function(options) {
          var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
            "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

          if (!document.getElementById('custom_notifications')) {
            alert('doesnt exists');
          } else {
            $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
            $('#custom_notifications #notif-group').append(message);
            cnt++;
            CustomTabs(options);
          }
        };

        CustomTabs = function(options) {
          $('.tabbed_notifications > div').hide();
          $('.tabbed_notifications > div:first-of-type').show();
          $('#custom_notifications').removeClass('dsp_none');
          $('.notifications a').click(function(e) {
            e.preventDefault();
            var $this = $(this),
              tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
              others = $this.closest('li').siblings().children('a'),
              target = $this.attr('href');
            others.removeClass('active');
            $this.addClass('active');
            $(tabbed_notifications).children('div').hide();
            $(target).show();
          });
        };

        CustomTabs();

        var tabid = idname = '';

        $(document).on('click', '.notification_close', function(e) {
          idname = $(this).parent().parent().attr("id");
          tabid = idname.substr(-2);
          $('#ntf' + tabid).remove();
          $('#ntlink' + tabid).parent().remove();
          $('.notifications a').first().addClass('active');
          $('#notif-group div').first().css('display', 'block');
        });
		
      });
    </script>
    <!-- /Custom Notification -->
	
    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->