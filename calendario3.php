
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fullcalendar.min.css">
	    <script src="js/jquery.min.js"></script>
		<script src="js/moment.min.js"></script>
		<script src="js/fullcalendar.min.js"></script>
		<script src="js/es.js"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
 		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>


	<!-- 	 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  
    <a class="navbar-brand" href="https://promomedics.byw-si.com.mx/">INICIO</a>
	<i class="fa fa-home" aria-hidden="true"></i>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"> </span>
	
    </button>
	<img class="" style="height: 40px;" src="/images/logo_small.png" alt="AGENDA">
  </div>
</nav> -->

<!-- <div class="clearfix"></div> -->

	
		<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarModal">
  Agendar
</button> -->
<div class="form-group">
    <label for="exampleFormControlSelect1">Medico</label>
    <select class="form-control" id="medicos">
      <option>SELECCIONA UN MEDICO</option>
    </select>
  </div>
  <div class="clearfix"></div>
  <br>
		<div class="row">
			<div class="col-5">
					<div id="calendarioWeb"></div>
					
					<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarModal"> -->
  <!-- Agendar -->
</button>
			</div>
				<div class="col-7 align-items-end bg-dark text-white">
					<!-- <div id="calendarioWeb2"></div> -->
					<div class="row">
						<div class="col-6">
								<div class="form-group">
						    <label for="formGroupExampleInput" >Paciente</label>
						    <input type="text" class="form-control bg-light" id="formGroupExampleInput" placeholder="Example input placeholder">
						  </div>
						  <div class="form-group">
						    <label for="formGroupExampleInput2" >Primera cita</label>
						    <input type="text" value="NO"class="form-control bg-light" id="formGroupExampleInput2" placeholder="Another input placeholder">
						  </div>
						  <div class="form-group">
						    <label for="formGroupExampleInput2" >Segunda cita</label>
						    <input type="text" value="NO" class="form-control bg-light" id="formGroupExampleInput2" placeholder="Another input placeholder">
						  </div>
						  <div class="form-group">
						    <label for="formGroupExampleInput2" >Tercera cita</label>
						    <input type="text"  value="NO" class="form-control bg-light" id="formGroupExampleInput2" placeholder="Another input placeholder">
						  </div>
						  <div class="form-group">
						    <label for="formGroupExampleInput2" >Cuarta cita</label>
						    <input type="text" value="NO" class="form-control bg-light" id="formGroupExampleInput2" placeholder="Another input placeholder">
						  </div>
						</div>
						

					</div>
					
					<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarModal"> -->
  <!-- Agendar -->
</button>
			</div>
			
<!-- <div id="calendarioWeb2"></div> -->
		</div>
		
	
	<script type="text/javascript">
		
		$(document).ready(function(){
			//PARA CUANDO SE SELECCIONE EL MEDICO MANDAREMOS A LLAMAR A SUS CONSULTORIOS
			$( "#modalMedico" ).change(function() {
				 alert($( "#modalMedico" ).val());
				 var id= $( "#modalMedico" ).val();
				 var url="https://api.promo.byw-si.com.mx/api/consultorio/";
				 var peticion =url+id;
				  $.ajax({
			      url: peticion,
			      method: "GET",
			      dataType: "json"
			    }).done(function( data ) {
			        // alert("Todo bien");
			        // console.log(data,"JSON");
			        $.each(data, function(i, item) {
			        		// modalConsultorio
						    // console.log(data[i]);
						  //   $("medicos").each(function(i){ 
   					// 		 this.src = "test" + i + ".jpg"; 
								// });
								$("#modalConsultorio").append('<option value='+data[i].ID+'>'+data[i].nombre+'</option>');
								// $("#medicos").append('<option value='+data[i].ID+'>'+data[i].nombre+'</option>');
						}); //Si pones el content-type en PHP no necesitas parse         
			   		 });
				});

				// function enviar(){
				// 	 paciente = $.trim($('#paciente').val());
    //       			 edad = $.trim($('#edad').val());
    //       			 data = {
			 //              paciente: paciente, 
			 //              edad: edad
			 //            };
				// 	$.ajax({
			 //                method:'POST',
			 //                url: 'http://127.0.0.1:8000/api/agenda',
			 //                data: {
			 //                    action:'cita',
			 //                    data: $.toJSON(data),
			 //                }
			 //            }).done(item => {
			 //                if(item.error){
			 //                    msg = 'No se encontro al usuario. Verifica tus datos.';
			 //                    err.append(msg);
			 //                    err.addClass('alert-danger');
			 //                    btn.before(err);
			 //                    btn.removeAttr('disabled');
			 //                }else{
			 //                   console.log('Error');
			 //                }
			 //            }, 'json');

				// }



			//PETICION PARA OBTENER TODAS LAS CITAS
			 $.ajax({
			      url: "https://api.promo.byw-si.com.mx/api/agenda",
			      method: "GET",
			      dataType: "json"
			    }).done(function( data ) {
			        // alert("Todo bien");
			        console.log(data,"JSON");
			        $.each(data, function(i, item) {

						    // console.log(data[i].paciente);
						  //   $("medicos").each(function(i){ 
   					// 		 this.src = "test" + i + ".jpg"; 
								// });
								// $("#medicos").append('<option value='+data[i].ID+'>'+data[i].nombre+'</option>');
						}); //Si pones el content-type en PHP no necesitas parse         
			    });
			     $.ajax({
			      url: "https://api.promo.byw-si.com.mx/api/medico",
			      method: "GET",
			      dataType: "json"
			    }).done(function( data ) {
			        // alert("Todo bien");
			        // console.log(data,"JSON MEDICO"); 
			  
			        
			         $.each(data, function(i, item) {

						    // console.log(data[i].paciente);
						  //   $("medicos").each(function(i){ 
   					// 		 this.src = "test" + i + ".jpg"; 
								// });
								//       //HACEMOS APPEND AL SELECT EN DONDE NOS MOSTRARA LA LISTA DE MEDICOS
								$("#modalMedico").append('<option value='+data[i].ID+'>'+data[i].nombre+' '+data[i].paterno+' '+data[i].materno+' </option>');
								$("#medicos").append('<option value='+data[i].ID+'>'+data[i].nombre+'</option>');
						}); //Si pone
			        
			        //Si pones el content-type en PHP no necesitas parse         
			    }); 
			    $.ajax({
			      url: "https://api.promo.byw-si.com.mx/api/paciente",
			      method: "GET",
			      dataType: "json"
			    }).done(function( data ) {
			        // alert("Todo bien");
			        // console.log(data,"JSON MEDICO"); 
			  
			        
			         $.each(data, function(i, item) {

						    // console.log(data[i].paciente);
						  //   $("medicos").each(function(i){ 
   					// 		 this.src = "test" + i + ".jpg"; 
								// });
								let espacio= ""
								let nombre =data[i].nombre+data[i].paterno+data[i].materno;

								//       //HACEMOS APPEND AL SELECT EN DONDE NOS MOSTRARA LA LISTA DE MEDICOS
								$("#modalPaciente").append('<option value='+data[i].id_paciente+'>'+data[i].nombre+' '+data[i].paterno+' '+data[i].materno+'</option>');
								// $("#medicos").append('<option value='+data[i].ID+'>'+data[i].nombre+'</option>');
						}); //Si pone
			        
			        //Si pones el content-type en PHP no necesitas parse         
			    }); 


			  
			$('#calendarioWeb').fullCalendar({
				lang: 'es',
				header:{
					left:'today,prev,next',
					center:'title',
					right:'month,basicWeek,basicDay,agendaWeek,agendaDay'
				},
				dayClick:function(date,jsEvent,view){
				/* 	swal("cota para la fecha: "+date.format()); */
					$("#FECHA").val(date.format());
					$("#agendarModal").modal();
				},
					//pro
					events:'https://api.promo.byw-si.com.mx/api/agenda',
					// events:'http://127.0.0.1:8000/api/agenda',
					// events: [
					// 	    {
					// 		    id: 1,
					// 		    title: "  Francisco Mendez Roa",
					// 		    start: "2021-10-07",
					// 		    hora_consulta: "12:00 hrs",
					// 		    aseguradora: "GNP",
					// 		    telefono1: " 56097645",
					// 		    telefono2: " 5578908765",
					// 		   telefono3: "",
					// 		   costoConsulta: "350",
					// 		   recado: "Favor de recordarme de mi cita un dia antes.",
					// 		   edad: "2 años",
					// 		   comoSeEntero: " Internet"
					// 		  }
					// 		  
					// 	  ],
					// https://promomedics.api.byw-si.com.mx/agenda
					//desarrollo
					// events:'https://localhost/promomedics/citas.php',
				//CUANDO DEN CLICK SOBRE UN DIA EN UNA CITA SE VA A DESPLEGAR EL MODAL
				eventClick:function(callEvent,jsEvent,view){

					// console.log('DATOS: ',callEvent,jsEvent,view);

					// $("#identificador").html(callEvent.id);
					// $("#paciente").html(callEvent.title);
					// $("#descripcionCita").html(callEvent.start);
					// $("#hora_consulta").html(callEvent.hora_consulta);
					// $("#aseguradora").html(callEvent.aseguradora);
					// $("#telefono1").html(callEvent.telefono1);
					// $("#telefono2").html(callEvent.telefono2);
					// $("#telefono3").html(callEvent.telefono3);
					// $("#costoConsulta").html(callEvent.costoConsulta);
					// $("#recado").html(callEvent.recado);
					// $("#edad").html(callEvent.edad);
					let fechaAux = callEvent.start.format();
						
					$("#PACIENTE_EDIT").val(callEvent.title);
					$("#FECHA_EDIT").val(fechaAux);
					$("#ID_EDIT").val(callEvent.id);
					console.log('DATOS: ',callEvent);
					$("#hora_consulta").val();
					$("#EDAD_EDIT").val(callEvent.edad);
					$("#telefono1_EDIT").val(callEvent.telefono1);
					$("#telefono2_EDIT").val(callEvent.telefono2);
					$("#telefono3_EDIT").val(callEvent.telefono3);
					$("#costoConsulta_EDIT").val(callEvent.costoConsulta);
					$("#recado_EDIT").val(callEvent.recado);
					// alert("EDITAR");

					$("#exampleModal").modal();
				}
				
				
			});
			//ESTE CALENDARIO ES LA LISTA DE LAS CITAS DEL MEDICO UNA VEZ SELECCIONADO
			$('#calendarioWeb2').fullCalendar({
				// plugins: [ 'list' ],
				header:{
					// defaultView: 'listDay',
						
				},
				dayClick:function(date,jsEvent,view){
				/* 	swal("cota para la fecha: "+date.format()); */
					$("#FECHA").val(date.format());
					$("#agendarModal").modal();
				},
				defaultView: 'listDay',
					//pro
					events:'https://api.promo.byw-si.com.mx/api/agenda',
					// events:'http://127.0.0.1:8000/api/agenda',
									// events: [
							  //   {
							  //     id: 'a',
							  //     title: 'my event',
							  //     start: '2021-10-07'
							  //   }
							  // ],
					// https://promomedics.api.byw-si.com.mx/agenda
					//desarrollo
					// events:'https://localhost/promomedics/citas.php',
				//CUANDO DEN CLICK SOBRE UN DIA EN UNA CITA SE VA A DESPLEGAR EL MODAL
				eventClick:function(callEvent,jsEvent,view){

					$("#identificador").html(callEvent.id);
					$("#paciente").html(callEvent.title);
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

					$("#persona").val(callEvent.title);
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





		}); //fin del document.ready


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
								      	<form action="" method="post">
								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" >FECHA</span>
										  </div>
										   <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="fecha" id="FECHA" readonly="">
										  </div>
										   <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Hora</span>
										  </div>
										  <input type="time" class="form-control" id="hora" aria-label="Sizing example input" name="hora" aria-describedby="inputGroup-sizing-sm">
										  </div>

								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Paciente</span>
										  </div>
										<!--   <input type="text" class="form-control" id="paciente" aria-label="Sizing example input" name="paciente" aria-describedby="inputGroup-sizing-sm"> -->
										   <select class="custom-select" id="modalPaciente">
										    <option selected>Elige el paciente</option>
										  </select>
										   <input type="hidden" id="nombrePaciente">
										   <input type="hidden" id="paternoPaciente">
										   <input type="hidden" id="maternoPaciente">
										  </div>
										 

										    <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Edad</span>
										  </div>
										  <input type="number" class="form-control" id="edad" name="edad" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>

										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
										  </div>
										  <input type="number" class="form-control" id="telefono1" name="telefono1" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Celular</span>
										  </div>
										  <input type="number" class="form-control" id="telefono2" name="telefono2" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Otro</span>
										  </div>
										  <input type="number" class="form-control" id="telefono3" name="telefono3" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<!-- MEDICOS LIST -->
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Medicos</label>
										  </div>
										  <select class="custom-select" id="modalMedico">
										    <option selected>Elige el medico</option>
										  </select>
										</div>
										<!-- CONSULTORIOS LIST -->
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
										    <label class="input-group-text" for="inputGroupSelect01">Consultorio</label>
										  </div>
										  <select class="custom-select" id="modalConsultorio">
										    <option selected>Elige el consultorio</option>
										  </select>
										</div>
										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text">$Costo consulta</span>
										  </div>
										  <input type="number" class="form-control" id="costoConsulta" name="costoConsulta" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group">

										  <div class="input-group-prepend">
										    <span class="input-group-text">Recado</span>
										  </div>
										  <textarea class="form-control" id="recado" name="recado" aria-label="With textarea"></textarea>
										</div>
								   
								      </div>
								      
								      <div class="modal-footer">
								       
								         <button type="button" class="btn btn-primary" onclick="enviar();">AGENDAR</button>
								
								         <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								      </div>
								       </form> 
								       <!-- AQUI TERMINA EL FORM -->
								    </div>
								  </div>
								</div>

							<!-- Modal  PARA VER CITA-->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<form action="" method="post">
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
										  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="FECHA_EDIT"  name="FECHA_EDIT" readonly="">
										  </div>

								      	<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Paciente</span>

										  </div>
										  <input type="text" class="form-control"  id="PACIENTE_EDIT"  name="PACIENTE_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										 <!--  <input type="text" id="ID_EDIT" hidden> -->
										   <input type="text" class="form-control"  id="ID_EDIT" name="ID_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
										  </div>

										    <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Edad</span>
										  </div>
										  <input type="number" class="form-control" id="EDAD_EDIT" name="EDAD_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>

										  <div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Telefono</span>
										  </div>
										  <input type="number" class="form-control"  id="telefono1_EDIT" name="telefono1_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Celular</span>
										  </div>
										  <input type="number" class="form-control"  id="telefono2_EDIT"  name="telefono2_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group input-group-sm mb-3">
										  <div class="input-group-prepend">
										    <span class="input-group-text" id="inputGroup-sizing-sm">Otro</span>
										  </div>
										  <input type="number" class="form-control" id="telefono3_EDIT" name="telefono3_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
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
										  <input type="text" class="form-control" id="costoConsulta_EDIT" name="costoConsulta_EDIT" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
										</div>
										<div class="input-group">

										  <div class="input-group-prepend">
										    <span class="input-group-text">Recado</span>
										  </div>
										  <textarea class="form-control" id="recado_EDIT" name="recado_EDIT" aria-label="With textarea"></textarea>
										</div>
								   
								      </div>
								      <div class="modal-footer">
								       
								         <button type="button" class="btn btn-primary" onclick="actualizarCita();">ACTUALIZAR</button>
								
								         <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
								      </div>
								    </div>
								</form>
								  </div>
								</div>

	</div><!-- FIN DEL CONTAINER -->

				
<script>
	//CON ESTA FUNCION SE ACTUALIZA CADA 5 MINUTOS LA PAGINA
	  // setInterval("actualizar()",50000);

	
	function enviar(){
					 paciente = $.trim($('#modalPaciente').val());
					 // alert(paciente);
					 hora = $.trim($('#hora').val());
          			 edad = $.trim($('#edad').val());
          			 telefono1=$.trim($('#telefono1').val());
          			 telefono2=$.trim($('#telefono2').val());
          			 telefono3=$.trim($('#telefono3').val());
          			 medico=$('#modalMedico').val();
          			 consultorio=$('#modalConsultorio').val();
          			 costo=$('#costoConsulta').val();
          			 recado=$('#recado').val();
          			 fecha= $('#FECHA').val();
          			 data = {
			              paciente: paciente, 
			              edad: edad,
			              hora:hora,
			              telefono1:telefono1,
						  telefono2:telefono2,
					      telefono3:telefono3,
						  medico:medico,
						  consultorio:consultorio,
						  recado:recado,
						  costo:costo,
						  fecha:fecha
			            };
					$.ajax({
			                method:'POST',
			                url: 'https://api.promo.byw-si.com.mx/api/agenda',
			                // url: 'http://127.0.0.1:8000/api/agenda',
			                data: {
			                    action:'cita',
			                    data: data,
			                }
			            }).done(item => {
			                if(item.error){
			                    msg = 'No se encontro al usuario. Verifica tus datos.';
			                    err.append(msg);
			                    err.addClass('alert-danger');
			                   
			                   
			                    btn.before(err);
			                    btn.removeAttr('disabled');

			                }else{
			                	 $("#agendarModal").removeClass('selected');
			                   console.log('Success');
			                    window.location = "https://promomedics.byw-si.com.mx/calendario.php";
			                }
			            }, 'json');
			            location.reload();

				}
				function actualizarCita(){
						paciente = $.trim($('#modalPaciente').val());
					 // alert(paciente);
					 id_cita = $.trim($('#ID_EDIT').val());
					 hora = $.trim($('#hora').val());
          			 EDAD = $.trim($('#EDAD_EDIT').val());
          			 TELEFONO1=$.trim($('#telefono1').val());
          			 TELEFONO2=$.trim($('#telefono2').val());
          			 TELEFONO3=$.trim($('#telefono3').val());
          			 medico=$('#modalMedico').val();
          			 consultorio=$('#modalConsultorio').val();
          			 COSTO=$('#costoConsulta_EDIT').val();
          			 RECADO=$('#recado_EDIT').val();
          			 fecha= $('#FECHA').val();
          			 data = {
          			 	_token:'{{ csrf_token() }}',
			              paciente: paciente, 
			              marco:"hola",
			              edad: EDAD,
			              hora:hora,
			              telefono1:TELEFONO1,
						  telefono2:TELEFONO2,
					      telefono3:TELEFONO3,
						  medico:medico,
						  consultorio:consultorio,
						  recado:RECADO,
						  costo:COSTO,
						  fecha:fecha,
						  id_cita:id_cita
			            };
					$.ajax({
			                method:'POST',
			                url: 'https://api.promo.byw-si.com.mx/api/agenda/'+id_cita,
			                // url: 'http://127.0.0.1:8000/api/agenda/'+id_cita,
			                // type: "PATCH",
			                data: {
			                    action:'cita',
			                    data: data,
			                }
			            }).done(item => {
			                if(item.error){
			                    msg = 'No se encontro al usuario. Verifica tus datos.';
			                    err.append(msg);
			                    err.addClass('alert-danger');
			                   
			                   
			                    btn.before(err);
			                    btn.removeAttr('disabled');

			                }else{
			                	 $("#agendarModal").removeClass('selected');
			                   console.log('Success');
			                    window.location = "https://promomedics.byw-si.com.mx/calendario.php";
			                }
			            }, 'json');
			            location.reload();

				}

	  function actualizar(){
	  	location.reload();
	  }
</script>				


          <!-- 
            $CITA->status = $request->data["status"];
            $CITA->fechaCreacion = $request->data["fechaCreacion"];
            $CITA->fechaActualizacion = $request->data["fechaActualizacion"];
            $CITA->usuarioCreacionId = $request->data["usuarioCreacionId"];
            $CITA->usuarioActualizacionId = $request->data["usuarioActualizacionId"];
            $CITA->id_consultorio = $request->data["id_consultorio"];
            $CITA->paciente = $request->data["paciente"];
            $CITA->fecha_consulta = $request->data["fecha_consulta"];
            $CITA->hora_consulta = $request->data["hora_consulta"];
            $CITA->aseguradora = $request->data["aseguradora"];
            $CITA->mail = $request->data["mail"];
            $CITA->telefono1 = $request->data["telefono1"];
            $CITA->telefono2 = $request->data["telefono2"];
            $CITA->telefono3 = $request->data["telefono3"];
            $CITA->consultaPrimeraVez = $request->data["consultaPrimeraVez"];
            $CITA->consultaSubsecuente = $request->data["consultaSubsecuente"];
            $CITA->consultaPreferencial1 = $request->data["consultaPreferencial1"];
            $CITA->consultaPreferencial2 = $request->data["consultaPreferencial2"];
            $CITA->consultaRevision = $request->data["consultaRevision"];
            $CITA->consultaEstudios = $request->data["consultaEstudios"];
            $CITA->consultaUrgencia = $request->data["consultaUrgencia"];
            $CITA->costoConsulta = $request->data["costoConsulta"];
            $CITA->recado = $request->data["recado"];
            $CITA->comoSeEntero = $request->data["comoSeEntero"];
            $CITA->edad = $request->data["edad"];
            $CITA->tutor = $request->data["tutor"]; -->