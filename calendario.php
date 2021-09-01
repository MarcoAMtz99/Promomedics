<?php 
  $titulo = "Calendario";
  include 'header.php'; 

/*   $aperm = $_SESSION['perm'];
  if(!array_key_exists(MOD_MEDICOS, $aperm)){
    include '403.php';
    exit(0);
  }else{
    $perm = $aperm[MOD_MEDICOS];
    $perm = $perm['action']; */
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
                      <h2>AGENDA <small></small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <?php if($perm == 'EDIT') : ?>
                        <li><a id="btnAdd" class="add-link"><i class="fa fa-plus"></i> Agregar Grupo</a></li>
                        <?php endif; ?>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <p class="text-muted font-13 m-b-30">
                      </p>
                
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTabs" class="nav nav-tabs bar_tabs" role="tablist">
                 <!--  <li role="presentation" class="active">
                    <a href="#general-tab" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">DATOS MEDICOS</a>
                  </li> -->
                  <li role="presentation" class="">
                    <a href="#consultorios-tab" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">AGENDAR CITA</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#contacto-tab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Medios de Contacto</a>
                  </li>
                  <li role="presentation" class="">
                    <a href="#profesional-tab" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">CONFIRMACION</a>
                  </li>
                 <!--  <li role="presentation" class="">
                    <a href="#curriculum-tab" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">ALERTAS</a>
                  </li> -->
            
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="general-tab" aria-labelledby="general-tab">
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-12">







                    </div>
                  </div>
            </div>
          </div>


        <div role="tabpanel" class="tab-pane fade" id="consultorios-tab" aria-labelledby="consultorios-tab">
                    <?php include 'calendario/datos.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="contacto-tab" aria-labelledby="contacto-tab">
                    <?php include 'calendario/agendar.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="profesional-tab" aria-labelledby="profesional-tab">
                    <?php include 'calendario/medios.php'; ?>
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="curriculum-tab" aria-labelledby="curriculum-tab">
                    <?php include 'calendario/confirmacion.php'; ?>
                  </div>


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

<!-- 
    <script>
      $(document).ready(function() {

        getMedicos();

      function getMedicos(){
        NProgress.start();
        $.post('core/agenda/getMedicos', 
          {}, 
          function(resp) {
          
            console.log('datos grupo medico',resp.item);
            //  $.each(resp, function(index){
                addItemRow( resp.item,0);
             // });
              $("[data-toggle='tooltip']").tooltip();
            
            doTable('#tbl-items', 5);
            NProgress.done();
        },'json');
      }

     

    </script> -->