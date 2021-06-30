<?php

include 'conex.php';

$user = $_SESSION['user'];
$usertype = $_SESSION['perfil'];
$idSesion = $_SESSION['logID'];
$aperm = $_SESSION['perm'];

if(!$user){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}
if($usertype > 2){
	if(!array_key_exists(MOD_MEDICO, $aperm)){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}
	/*if(($usertype == 3 || $usertype == 4) && $med != $_SESSION['medico']){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}else{*/
	  $perm = $aperm[MOD_MEDICO];
	  $edita = false;
	  if($perm['action'] == 'EDIT') $edita = true;
	//}
}else{
	if(!array_key_exists(MOD_MEDICOS, $aperm)){
		echo "Acceso restringido. You shall not pass..";
		exit(0);
	}else{
	  $perm = $aperm[MOD_MEDICOS];
	  $edita = false;
	  if($perm['action'] == 'EDIT') $edita = true;
	}
}

/*if(!$user || !array_key_exists(MOD_MEDICOS, $aperm)){
	echo "Acceso restringido. You shall not pass..";
	exit(0);
}else{
	$perm = $aperm[MOD_MEDICOS];
	$edita = false;
	if($perm['action'] == 'EDIT') $edita = true;
	
}*/
	$action = $_POST['action'];
	$dataString = $_POST['data'];
	$data = json_decode($dataString);

	include 'Log.class.php';
	$log = new Log($user,$idSesion);

$arrCurri = array( array('tbl' => 'medico_uni', 'btn' => 'btncu', 'log' => 'Uni'), 
				array('tbl' => 'medico_cer_con', 'btn' => 'btncc', 'log' => 'Cert'), 
				array('tbl' => 'medico_mie_aso', 'btn' => 'btncm', 'log' => 'Cons'), 
				array('tbl' => 'medico_cur_sim', 'btn' => 'btncs', 'log' => 'Curs'), 
				array('tbl' => 'medico_dat_esp', 'btn' => 'btncd', 'log' => 'Esp') 
			);

switch ($action) {
	/** MEDICOS **/
	case 'getMedicos':
		$SQL = "SELECT ID, CONCAT(m.nombre, ' ', m.paterno, ' ', m.materno) AS nombre, num_cedula, 
					id_user, email, DATE_FORMAT(last_access,'%d/%m/%Y %H:%i:%s') AS acceso, fk_perfil, u.status, 
					IFNULL((SELECT especialidad FROM medico_especialidad WHERE id_medico = m.ID),'') AS especialidad
					FROM medico m, seg_user u
						WHERE u.id_user = (SELECT id_user FROM seg_user WHERE fk_medico = ID ORDER BY id_user LIMIT 1) AND (SELECT COUNT(*) FROM seg_user WHERE fk_medico = ID) > 0 
						ORDER BY m.nombre, m.paterno, m.materno; ";
		$res = mysql_query($SQL);

		$arrItems = array();
		while ($item = mysql_fetch_assoc($res)) {
			$item['act'] = '';
			$item['rea'] = '';
			$item['neg'] = '';
			if($item['fk_perfil'] == 3 && $edita && $item['status'] == 3){
				$item['act'] = '<button class="btn btn-success btn-xs btn-act" data-toggle="tooltip" title="Activar"><i class="fa fa-check fa-fw"></i></button>';	
				$item['rea'] = '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>';
				$item['neg'] = '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			}else if($item['fk_perfil'] == 4 && $edita){
				$item['neg'] = '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			}else if($item['status'] == 4){
				$item['rea'] = '<button class="btn btn-info btn-xs btn-rea" data-toggle="tooltip" title="Reactivar"><i class="fa fa-refresh fa-fw"></i></button>';
			}
			$arrItems[] = $item;
		}

		$acciones = '';
		if($edita){
			$acciones = '<button class="btn btn-primary btn-xs btn-edit" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil fa-fw"></i></button> ';
			//$acciones .= '<button class="btn btn-danger btn-xs btn-neg" data-toggle="tooltip" title="Negar"><i class="fa fa-ban fa-fw"></i></button>';
			$acciones .= '<button class="btn btn-danger btn-xs btn-del" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash fa-fw"></i></button>';
		}
		
		$arrRes = array('error' => false, 'items' => $arrItems, 'actions' => $acciones);
		echo json_encode($arrRes);
		break;

	case 'getMedico':
			$id = $_POST['id'];

			$SQL = "SELECT ID, m.nombre, m.paterno, m.materno, num_cedula, 
					id_user, email, fk_medico
					FROM medico m, seg_user u
						WHERE u.id_user = $id AND m.ID = u.fk_medico; ";
			$res = mysql_query($SQL);

			$item = mysql_fetch_assoc($res);
			
			$arrRes = array('error' => false, 'item' => $item);	
		echo json_encode($arrRes);
		break;

	case 'getSubespecialidad':
		$esp = $_POST['esp'];

		$SQL = "SELECT nombre FROM subespecialidades WHERE id_especialidad = $esp; ";
		$res = mysql_query($SQL);

		$arr = array();
		while ($item = mysql_fetch_assoc($res)) {
			$item['nombre'] = utf8_encode($item['nombre']);
			$arr[] = $item;
		}

		echo json_encode($arr);
		break;

	case 'findMedico':
		$q = $_POST['q'];
		$esp = $_POST['e'];
		$sub = $_POST['s'];

		$espq = "";
		if($esp != 'Todas las Subespecialidades') $espq = " AND (SELECT especialidad FROM medico_especialidad WHERE id_medico = m.ID) = '$esp' ";

		$subq = "";
		if($sub != '-1') $subq = " AND (SELECT subespecialidad FROM medico_especialidad WHERE id_medico = m.ID) = '$sub' ";

		$SQL = "SELECT ID, CONCAT(m.nombre, ' ', m.paterno, ' ', m.materno) AS nombre, num_cedula, 
					id_user, email, DATE_FORMAT(last_access,'%d/%m/%Y %H:%i:%s') AS acceso, fk_perfil, u.status, 
					IFNULL((SELECT especialidad FROM medico_especialidad WHERE id_medico = m.ID),'') AS especialidad, 
					IFNULL((SELECT subespecialidad FROM medico_especialidad WHERE id_medico = m.ID),'') AS subespecialidad
					FROM medico m, seg_user u
						WHERE u.id_user = (SELECT id_user FROM seg_user WHERE fk_medico = ID ORDER BY id_user LIMIT 1) AND (SELECT COUNT(*) FROM seg_user WHERE fk_medico = ID) > 0  
							/*AND u.status = 1*/ AND (CONCAT(m.nombre, ' ', m.paterno, ' ', m.materno) LIKE '%$q%' OR num_cedula LIKE '%$q%') 
							$espq $subq 
						ORDER BY m.nombre, m.paterno, m.materno; ";
		$res = mysql_query($SQL);

		$arr = array();
		while ($med = mysql_fetch_assoc($res)){
			$arr[] = $med;
		}

		echo json_encode(array('items' => $arr, 'sql' => $SQL));
		break;

	case 'getConsultorios':
		$med = $_POST['med'];

		$SQL = "SELECT * FROM consultorio WHERE id_medico = $med AND status = 1; ";
		$res = mysql_query($SQL);

		$arr = array();
		while ($cons = mysql_fetch_assoc($res)) {
			$consu = array('ID' => $cons['ID'], 'nombre' => $cons['nombre']);

			$dir = $cons['calle'];
			$consu['dir'] = $dir;

			$SQLc = "SELECT * FROM consultorio_horario WHERE tipo = 1 AND fk_consultorio = ".$cons['ID']." ORDER BY dia, inicio; ";
			$resc = mysql_query($SQLc);
			$items = array();
			while ($hora = mysql_fetch_assoc($resc)) {
				$items[] = array('id' => $hora['id_horario'], 
								'dia' => $hora['dia'], 
								'hora' => substr($hora['inicio'], 0, 5).' - '.substr($hora['fin'], 0, 5));
			}
			$consu['hcons'] = $items;

			$SQLq = "SELECT * FROM consultorio_horario WHERE tipo = 1 AND fk_consultorio = ".$cons['ID']." ORDER BY dia, inicio; ";
			$resq = mysql_query($SQLq);
			$items = array();
			while ($hora = mysql_fetch_assoc($resq)) {
				$items[] = array('id' => $hora['id_horario'], 
								'dia' => $hora['dia'], 
								'hora' => substr($hora['inicio'], 0, 5).' - '.substr($hora['fin'], 0, 5));
			}
			$consu['hquir'] = $items;

			$arr[] = $consu;
		}

		echo json_encode($arr);
		break;



	default:
		# code...
		break;
}




function randomString($tam=8){
    $source = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    if($tam>0){
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$tam; $i++){
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
 
    }
    return $rstr;
}


?>