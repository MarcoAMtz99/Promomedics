<?php
/* 	include('topmenu.php'); */
	/* include('header.php');
	include('sidebar.php'); */
 ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fullcalendar.min.css">
	<script src="js/jquery.min.js"></script>
		<script src="js/moment.min.js"></script>
		<script src="js/fullcalendar.min.js"></script>
		<!-- <script src="js/es.js"></script> -->
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
 		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

		 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  
    <a class="fa fa-home" href="https://promomedics.byw-si.com.mx/">INICIO</a>
	<i class="fa fa-home" aria-hidden="true"></i>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"> </span>
	
    </button>
	<img class="" style="height: 40px;" src="/images/logo_small.png" alt="AGENDA">
  </div>
</nav>
<div class="clearfix"></div>
	<div class="container" style="background-image: url(/images/bg.jpg);">
		<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarModal">
  Agendar
</button> -->
		<div class="row">
			<div class="col-6">
					<div id="calendarioWeb"></div>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarModal">
  Agendar
</button>
			</div>
			<!-- <div class="col-6">
					<div class="" style="background: red">HOLA</div>

			</div> -->

		</div>
		
	</div>
	<script type="text/javascript">
		
		$(document).ready(function(){
			$('#calendarioWeb').fullCalendar({
				header:{
					left:'today,prev,next',
					center:'title',
					right:'month,basicWeek,basicDay,agendaWeek,agendaDay'
				},
				dayClick:function(date,jsEvent,view){
					alert("Valor seleccionado: "+date.format());
					$("#FECHA").val(date.format());
					$("#agendarModal").modal();
				},
				
					events:'https://promomedics.byw-si.com.mx/citas',
				
				//CUANDO DEN CLICK SOBRE UN DIA EN UNA CITA SE VA A DESPLEGAR EL MODAL
				eventClick:function(callEvent,jsEvent,view){

					$("#identificador").html(callEvent.id);
					$("#paciente").html(callEvent.paciente);
					$("#descripcionCita").html(callEvent.start);
					$("#hora_consulta").html(callEvent.hora_consulta);
					$("#aseguradora").html(callEvent.aseguradora);
					$("#telefono1").html(callEvent.telefono1);
					$("#telefono2").html(callEvent.telefono2);
					$("#telefono3").html(callEvent.telefono3);
					$("#costoConsulta").html(callEvent.costoConsulta);
					$("#recado").html(callEvent.recado);
					$("#edad").html(callEvent.edad);
					let fechaAux = callEvent.start.format();

					$("#persona").val(callEvent.paciente);
					$("#descripcionCita").val(fechaAux);
					console.log('persona: ',callEvent.paciente);
					$("#hora_consulta").val();
					$("#edad").val(callEvent.edad);
					$("#telefono1").val(callEvent.telefono1);
					$("#telefono2").val(callEvent.telefono2);
					$("#telefono3").val(callEvent.telefono3);
					$("#costoConsulta").val(callEvent.costoConsulta);
					$("#recado").val(callEvent.recado);

					$("#exampleModal").modal();
				}
				
			});
		});

	</script>
	

<!-- Modal  PARA CREAR CITA-->
								<div class="modal fade" id="agendarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="tituloCita"> AGENDAR CITA</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" >FECHA</span>
										  </div>
										  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="FECHA" readonly="">
										  </div>

								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Paciente</span>
										  </div>
										  <input type="text" class="form-control" id="paciente" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										  </div>

										    <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Edad</span>
										  </div>
										  <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>

										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
										  </div>
										  <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Celular</span>
										  </div>
										  <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Otro</span>
										  </div>
										  <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<!-- MEDICOS LIST -->
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Medicos</label>
										  </div>
										  <select class="custom-select" id="inputGroupSelect01">
										    <option selected>Choose...</option>
										    <option value="1">One</option>
										    <option value="2">Two</option>
										    <option value="3">Three</option>
										  </select>
										</div>
										<!-- CONSULTORIOS LIST -->
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Consultorio</label>
										  </div>
										  <select class="custom-select" id="inputGroupSelect01">
										    <option selected>Choose...</option>
										    <option value="1">One</option>
										    <option value="2">Two</option>
										    <option value="3">Three</option>
										  </select>
										</div>
										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">$Costo consulta</span>
										  </div>
										  <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group">

										  <div class="input-group-prepend">
										    <span class="input-group-text">Recado</span>
										  </div>
										  <textarea class="form-control" aria-label="With textarea"></textarea>
										</div>
								   
								      </div>
								      <div class="modal-footer">
								       
								         <button type="button" class="btn btn-primary">AGENDAR</button>
								
								         <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								      </div>
								    </div>
								  </div>
								</div>
<!-- Modal  PARA VER CITA-->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="tituloCita"> VER CITA</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								      	<input type="hidden" id="identificador">
								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" aria-label="Sizing example input">FECHA</span>
										  </div>
										  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="descripcionCita" readonly="">
										  </div>

								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Paciente</span>
										  </div>
										  <input type="text" class="form-control"  id="persona" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										  </div>

										    <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Edad</span>
										  </div>
										  <input type="number" class="form-control" id="edad" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>

										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
										  </div>
										  <input type="number" class="form-control"  id="telefono1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Celular</span>
										  </div>
										  <input type="number" class="form-control"  id="telefono2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Otro</span>
										  </div>
										  <input type="number" class="form-control" id="telefono3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<!-- MEDICOS LIST -->
									<!-- 	<div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Medicos</label>
										  </div>
										  <select class="custom-select" id="inputGroupSelect01">
										    <option selected>Choose...</option>
										    <option value="1">One</option>
										    <option value="2">Two</option>
										    <option value="3">Three</option>
										  </select>
										</div> -->
										<!-- CONSULTORIOS LIST -->
										<!-- <div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Consultorio</label>
										  </div>
										  <select class="custom-select" id="inputGroupSelect01">
										    <option selected>Choose...</option>
										    <option value="1">One</option>
										    <option value="2">Two</option>
										    <option value="3">Three</option>
										  </select>
										</div> -->
										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">$Costo consulta</span>
										  </div>
										  <input type="text" class="form-control" id="costoConsulta" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group">

										  <div class="input-group-prepend">
										    <span class="input-group-text">Recado</span>
										  </div>
										  <textarea class="form-control" id="recado" aria-label="With textarea"></textarea>
										</div>
								   
								      </div>
								      <div class="modal-footer">
								       
								         <button type="button" class="btn btn-primary">ACTUALIZAR</button>
								
								         <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								      </div>
								    </div>
								  </div>
								</div>

							


