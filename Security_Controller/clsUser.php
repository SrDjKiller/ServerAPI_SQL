<?php

class clsUser{

    private $db;
    private $conexion;
    private $procedureController;
    private $_user;
    private $_pwd;

    function __construct(){
        $this->_user = $_GET['user'];
        $this->_pwd = $_GET['pwd'];
    }

    function initConnection(){
        $this->db = new clsDBUtils();
        $this->conexion = $this->db->createConnection();
        $this->procedureController = new clsRequestDB($this->conexion);
    }

    function loginUser(): object{
        $this->initConnection();
        $login = $this->procedureController->prepareProcedure('sp_sap_user_login', [$this->_user,$this->_pwd]);
        $login = $this->procedureController->executeProcedure();
        $this->procedureController->fetchExecutionProcedure();
        return $this->procedureController->getDataXML();
    }

    function registerUser(): void{
        $this->initConnection();
        $_email = $_GET['mail'];
        $register = $this->procedureController->prepareProcedure('sp_sap_user_register', [$this->_user,$this->_pwd,$_email]);
        $register = $this->procedureController->executeProcedure();
        $this->procedureController->fetchExecutionProcedure();
    }
    
    function getXMLResponse(){
        return $this->procedureController->getDataXMLString();
    }
}

?>