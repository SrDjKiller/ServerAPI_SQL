<?php

class clsDBUtils{

    private $db;
    private $conexion;
    private $pServer;
    private $pPort;
    private $pDBName;
    private $pUserName;
    private $pPasswordDB;

    function __construct(){
        $config = new Config();
        $this->pServer = $config->server;
        $this->pPort = $config->port;
        $this->pDBName = $config->nameDatabase;
        $this->pUserName = $config->userName;
        $this->pPasswordDB = $config->passwordDb;
    }

    function createConnection(){
        $this->db = new clsDB($this->pServer, $this->pPort, $this->pDBName, $this->pUserName, $this->pPasswordDB);
        $this->conexion = $this->db->getPDODB();
        return $this->conexion;
    }
}

?>