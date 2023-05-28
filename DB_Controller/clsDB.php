<?php

include_once "./interfaces/ConnectionDbInterface.php";

class clsDB implements ConnectionDbInterface {

    private $_sqlServer;
    private $_port;
    private $_databaseName;
    private $_userName;
    private $_password;
    private $_db;

    function __construct($pSqlServer, $pPort, $_databaseName, $pUserName, $pPassword){
        $this->_sqlServer = $pSqlServer;
        $this->_port = $pPort;
        $this->_databaseName = $_databaseName;
        $this->_userName = $pUserName;
        $this->_password = $pPassword;
        $this->initConnection();
    }

    private function createObjectToConnectPDO(){
        $ObjectPDO = "sqlsrv:Server=".$this->_sqlServer.",".$this->_port.";Database=".$this->_databaseName;
        return $ObjectPDO;
    }
    private function setConnectionAttribute(){
        return $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function connectDB($conexionDB){
        $this->_db = new PDO($conexionDB, $this->_userName, $this->_password);
    }

    public function getPDODB(): PDO {
        return $this->_db;
    }

    public function initConnection(): void  {
        try {
            $getObjectPDO = $this->createObjectToConnectPDO();
            $this->connectDB($getObjectPDO);
            $this->setConnectionAttribute();
        } catch (Exception $error) {
            echo "No se ha podido conectar a la bd: ". $error -> getMessage();
        }
    }
}

?>