<?php 
	// ini_set('display_errors',0);
	//PRODUCCION
	// $conn = mysqli_connect('localhost','bywsicom_promo','!_WOXa9ZxWfP');
	// define('WP_DEBUG', false);
	// ini_set('log_errors','On');
	// ini_set('display_errors','Off');
	// ini_set('error_reporting', E_ALL );
	// define('WP_DEBUG', true);
	// define('WP_DEBUG_LOG', true);
	//DESARROLLO
	$conn = mysqli_connect('localhost','root','','promo');
		//PRODUCCION
	// mysqli_select_db($conn,'bywsicom_promo');
		//DESARROLLO
	mysqli_select_db($conn,'promo');


	if(!defined('URL_ROOT')){
		//PRODUCCION
		define('URL_ROOT', 'https://promomedics.byw-si.com.mx');
		//DESARROLLO
		// define('URL_ROOT', 'http://localhost/promomedics');
	}
	if(!defined('PAGE_TITLE')){
		define('PAGE_TITLE', 'Promomedics');
	}


	if (!isset($_SESSION)) {
		session_start();
	}
	/*if(!defined('SESSION_TIMEOUT')){
		define('SESSION_TIMEOUT', 120000000);
	}*/
	// CONST USUARIOS = 4;
	// TIPO (TABLA) PARA LOG
	// define('MODULOS',1);
	if ( !defined('MODULOS') ) define('MODULOS', 1);
	if ( !defined('PERFILES') )define('PERFILES',2);
	if ( !defined('PERMISOS') )define('PERMISOS',3);
	if ( !defined('USUARIOS') )define('USUARIOS',4);
	if ( !defined('SESION') )define('SESION', 5);
	if ( !defined('LOG') )define('LOG',6);
	
		if ( !defined('ESCOLARIDAD') )define('ESCOLARIDAD', 	7);
		if ( !defined('DEPARTAMENTOS') )define('DEPARTAMENTOS', 8);
		if ( !defined('PUESTOS') )define('PUESTOS', 		9);
		if ( !defined('ESPECIALIDAD') )define('ESPECIALIDAD', 	15);
		if ( !defined('SUBESPECIALIDAD') )define('SUBESPECIALIDAD', 16);
		if ( !defined('REDSOCIAL') )define('REDSOCIAL', 	10);
		if ( !defined('AREA') )define('AREA', 			11);
		if ( !defined('BENEFICIOS') )define('BENEFICIOS', 	12);
		if ( !defined('CONVENIOS') )define('CONVENIOS', 	13);
		if ( !defined('MEDIOSCONTACTO') )define('MEDIOSCONTACTO', 17);
		if ( !defined('ASEGURADORAS') )define('ASEGURADORAS', 	18);
		if ( !defined('MOTIVOS') )define('MOTIVOS', 		19);
		if ( !defined('SERVICIOS') )define('SERVICIOS', 	20);
		if ( !defined('CONDICIONES') )define('CONDICIONES', 	21);
		if ( !defined('TEMAINTERES') )define('TEMAINTERES', 	24);

	if ( !defined('MEDICOS') )define('MEDICOS', 		14);
	if ( !defined('GPOSMEDICOS') )define('GPOSMEDICOS', 	22);
	if ( !defined('CALENDARIO') )define('CALENDARIO', 	32);
	if ( !defined('PACIENTE') )define('PACIENTE', 	23);

	if ( !defined('CUPON') )define('CUPON', 	25);




	// MODULOS
	if ( !defined('MOD_SEGURIDAD') )define('MOD_SEGURIDAD', 	1);
	if ( !defined('MOD_MODULOS') )define('MOD_MODULOS', 		2);
	if ( !defined('MOD_PERFILES') )define('MOD_PERFILES', 		3);
	if ( !defined('MOD_USUARIOS') )define('MOD_USUARIOS', 		4);
	if ( !defined('MOD_PRECARGAS') )define('MOD_PRECARGAS', 	5);
	if ( !defined('MOD_GPOSMEDICOS') )define('MOD_GPOSMEDICOS', 	6);
	if ( !defined('MOD_TEMPLOS') )define('MOD_TEMPLOS', 		7);
	if ( !defined('MOD_NIVELES') )define('MOD_NIVELES', 		8);
	if ( !defined('MOD_PADRINOS') )define('MOD_PADRINOS', 		9);

	if ( !defined('MOD_ESCOLARIDAD') )define('MOD_ESCOLARIDAD', 	12);
		if ( !defined('MOD_REDES') )define('MOD_REDES', 		13);
		if ( !defined('MOD_PUESTOS') )define('MOD_PUESTOS', 		14);
		if ( !defined('MOD_ESPECIALIDAD') )define('MOD_ESPECIALIDAD', 	21);
		if ( !defined('MOD_SUBESPECIALIDAD') )define('MOD_SUBESPECIALIDAD', 22);
		if ( !defined('MOD_AREAS') )define('MOD_AREAS', 		23);
		if ( !defined('MOD_BENEFICIOS') )define('MOD_BENEFICIOS', 	24);
		if ( !defined('MOD_CONVENIOS') )define('MOD_CONVENIOS', 	25);
		if ( !defined('MOD_MEDIOSCONTACTO') )define('MOD_MEDIOSCONTACTO', 26);
		if ( !defined('MOD_ASEGURADORAS') )define('MOD_ASEGURADORAS', 	27);
		if ( !defined('MOD_MOTIVOS') )define('MOD_MOTIVOS', 		28);
		if ( !defined('MOD_SERVICIOS') )define('MOD_SERVICIOS', 	29);
		if ( !defined('MOD_CONDICIONES') )define('MOD_CONDICIONES', 	30);
		if ( !defined('MOD_TEMASINTERES') )define('MOD_TEMASINTERES', 	31);

	if ( !defined('MOD_MEDICOS') )define('MOD_MEDICOS', 		15);
	if ( !defined('MOD_MEDICO') )define('MOD_MEDICO', 		19);
	if ( !defined('MOD_GPOMEDICO') )define('MOD_GPOMEDICO', 	20);
	
	if ( !defined('MOD_PACIENTES') )define('MOD_PACIENTES', 	16);

	if ( !defined('MOD_CUPONES') )define('MOD_CUPONES', 	32);

 ?>