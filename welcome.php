<?php 
  $titulo = "Templos";
  include 'header.php'; 

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

          <!--div class="page-title">
            <div class="title_left">
              <h3>Templos <small>Sucursales de Padrinos Cristianos</small></h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          <pre>
            
          <?php print_r($_SESSION) ?>
          </pre>
          </div-->



          <h2>Bienvenido <strong><?php echo $username; ?></strong></h2>
          

          
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

        $('#mnu-tem').addClass('active');

        // WIZARD
        //$('#wizard').smartWizard({labelFinish:'Guardar'});

        $('.buttonNext').addClass('btn btn-default');
        $('.buttonPrevious').addClass('btn btn-default');
        $('.buttonFinish').addClass('btn btn-primary');

        // SELECT 2
        $(".select2_single").select2({
          placeholder: "Seleccione un Responsable",
          allowClear: true, 
          language: "es"
        });

        // INPUT MASK
        $(":input").inputmask();

        // VALIDADOR
          // initialize the validator function
        validator.message.date = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
          .on('blur', 'input[required], input.optional, select.required', validator.checkField)
          .on('change', 'select.required', validator.checkField)
          .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required').on('keyup blur', 'input', function() {
          validator.checkField.apply($(this).siblings().last()[0]);
        });

        // TABLA
        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true, 
          language: {
            "url": "js/Spanish.json"
            /*"lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Nothing found - sorry",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"*/
        }
        });
      });


    </script>
