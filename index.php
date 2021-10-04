<?php
  
  include_once 'core/conex.php';

  if(isset($_SESSION['user'])){
    //include 'welcome.php';
    if($_SESSION['perfil'] == 1)
    	header('Location: '.URL_ROOT.'/medicos.php');
    else if($_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4)
    	header('Location: '.URL_ROOT.'/medico/'.$_SESSION['medico']);
    else
      header('Location: '.URL_ROOT.'/welcome');
  }else{
    header('Location: '.URL_ROOT.'/login.php');
  }

?>