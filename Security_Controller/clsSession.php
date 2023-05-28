<?php

class clsSession{

    private $db;
    private $conexion;
    private $procedureController;
    private $_cid;
    private $product;

    function initConnection(){
        $this->db = new clsDBUtils();
        $this->conexion = $this->db->createConnection();
        $this->procedureController = new clsRequestDB($this->conexion);
    }

    function logoutUser(): object{
        $this->initConnection();
        $this->_cid = $_COOKIE['tokenID'];
        $logout = $this->procedureController->prepareProcedure('sp_sap_user_logout', [$this->_cid]);
        $logout = $this->procedureController->executeProcedure();
        $this->procedureController->fetchExecutionProcedure();
        return $this->procedureController->getDataXML();
    }

    function addToCart(){
        $this->initConnection();
        $this->_cid = $_COOKIE['tokenID'];
        $this->product = $_GET['product'];
        $logout = $this->procedureController->prepareProcedure('sp_sap_add_cart', [$this->product]);
        $logout = $this->procedureController->executeProcedure();
        $this->procedureController->fetchExecutionProcedure();
        return $this->procedureController->getDataXML();
    }

    function setCookie($guid){
        setcookie("tokenID", $guid, time() - 86400 );
        header('Set-Cookie: tokenID=' . urlencode($guid) . '; expires=' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT; path=/');
    }

    function destroyCookie(){
        unset($_COOKIE['tokenID']);
        setcookie('tokenID', '', time() - 3600, '/');
    }

    function getXMLResponse(){
        return $this->procedureController->getDataXMLString();
    }
}

?>