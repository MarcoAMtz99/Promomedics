<?php
	
	include 'conex.php';

	$_SESSION['user'] = null;
    $_SESSION['perfil'] = null;
    $_SESSION['nomuser'] = null;
    $_SESSION['logID'] = null;
    $_SESSION['perm'] = null;
	$_SESSION['last'] = null;

	unset($_SESSION['user']);
    unset($_SESSION['perfil']);
    unset($_SESSION['nomuser']);
    unset($_SESSION['logID']);
    unset($_SESSION['perm']);
	unset($_SESSION['last']);

	session_unset();
	session_regenerate_id(true);
	session_destroy();

	$sesion = '';
	if(isset($_GET['session'])) $sesion = '?session=0';

	//header('Location: '.URL_ROOT.'/login'/*.'?logged_out=true'*/);
	header('Location: '.URL_ROOT.'/login'.$sesion);

?>