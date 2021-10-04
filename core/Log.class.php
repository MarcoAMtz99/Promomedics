<?php

class Log {
    
    public $idUser = 0;
    public $idSesion = 0;
    public $action = '';
    public $data = '';
    public $record = 0;
    public $destination = 0;
    public $texto="";
    

    public function __construct($user,$logID){
    	$this->idUser = $user;
	    $this->idSesion = $logID;
        $this->action = 'action del evento';
	    $this->data = 'data del evento';
	    $this->record = 0;
	    $this->destination = 0;
    }
    
    public function setDatos($action,$data,$record,$destination){
        $this->action = $action;
        $this->data = $data;
        $this->record = $record;
        $this->destination = $destination;        
    }

    public function saveLog() {
        $SQLLOG = "INSERT INTO seg_log 
                                VALUES (NULL,
                                        $this->idUser,
                                        $this->idSesion,
                                        NOW(),
                                        '$this->action',
                                        '$this->data',
                                        $this->record,
                                        $this->destination); ";
                                        $conn = mysqli_connect('localhost','root','','promo');
		mysqli_query($conn,$SQLLOG);

        $this->updateSession();

        return $SQLLOG;
    }

    public function updateSession(){
        $SQLSes = "UPDATE seg_session SET finished = NOW() 
                        WHERE id_session = $this->idSesion; ";
                        $conn = mysqli_connect('localhost','root','','promo');
        $resSes = mysqli_query($conn,$SQLSes);

        return $resSes;
    }

    public function getInfo(){
        $texto = "/**************** Variables de Session *****************/";
    	$texto = $texto . "\n\n <br>idUser: " . $this->idUser;
        $texto = $texto . "<br><br>idSesion: " .$this->idSesion;
    	$texto = $texto . "<br>/*************** End variables de Session **************/";
        return $texto;
    }
}



?>

