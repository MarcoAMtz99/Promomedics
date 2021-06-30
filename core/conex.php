<?php 
	ini_set('display_errors',0);

	$conn = mysql_pconnect('localhost','root','');
	mysql_select_db('promo');


	if(!defined('URL_ROOT')){
		define('URL_ROOT', 'http://localhost/promo');
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

	// TIPO (TABLA) PARA LOG
	define('MODULOS', 		1);
	define('PERFILES', 		2);
	define('PERMISOS', 		3);
	define('USUARIOS', 		4);
	define('SESION', 		5);
	define('LOG', 			6);
	
	define('ESCOLARIDAD', 	7);
	define('DEPARTAMENTOS', 8);
	define('PUESTOS', 		9);
	define('ESPECIALIDAD', 	15);
	define('SUBESPECIALIDAD', 16);
	define('REDSOCIAL', 	10);
	define('AREA', 			11);
	define('BENEFICIOS', 	12);
	define('CONVENIOS', 	13);
	define('MEDIOSCONTACTO', 17);
	define('ASEGURADORAS', 	18);
	define('MOTIVOS', 		19);
	define('SERVICIOS', 	20);
	define('CONDICIONES', 	21);
	define('TEMAINTERES', 	24);

	define('MEDICOS', 		14);
	define('GPOSMEDICOS', 	22);

	define('PACIENTE', 	23);

	define('CUPON', 	25);




	// MODULOS
	define('MOD_SEGURIDAD', 	1);
	define('MOD_MODULOS', 		2);
	define('MOD_PERFILES', 		3);
	define('MOD_USUARIOS', 		4);
	define('MOD_PRECARGAS', 	5);
	define('MOD_GPOSMEDICOS', 	6);
	define('MOD_TEMPLOS', 		7);
	define('MOD_NIVELES', 		8);
	define('MOD_PADRINOS', 		9);

	define('MOD_ESCOLARIDAD', 	12);
		define('MOD_REDES', 		13);
		define('MOD_PUESTOS', 		14);
		define('MOD_ESPECIALIDAD', 	21);
		define('MOD_SUBESPECIALIDAD', 22);
		define('MOD_AREAS', 		23);
		define('MOD_BENEFICIOS', 	24);
		define('MOD_CONVENIOS', 	25);
		define('MOD_MEDIOSCONTACTO', 26);
		define('MOD_ASEGURADORAS', 	27);
		define('MOD_MOTIVOS', 		28);
		define('MOD_SERVICIOS', 	29);
		define('MOD_CONDICIONES', 	30);
		define('MOD_TEMASINTERES', 	31);

	define('MOD_MEDICOS', 		15);
	define('MOD_MEDICO', 		19);
	define('MOD_GPOMEDICO', 	20);
	
	define('MOD_PACIENTES', 	16);

	define('MOD_CUPONES', 	32);

 ?>