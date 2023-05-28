<?php

class clsSecurityController{

    private $userController;
    private $sessionController;

    public function doMethod(){
        $action = $_GET['action'];
            switch ($action){
                case 'login':
                    $response = $this->doLogin();
                    if($response->error==0){
                        $this->sessionController = new clsSession();
                        $this->sessionController->setCookie($response->conn_guid);
                    }
                    return $this->userController->getXMLResponse();
                break;
                case 'register':
                    $this->doRegister();
                    return $this->userController->getXMLResponse();
                break;
                case 'logout':
                    $this->doLogout();
                    return $this->sessionController->getXMLResponse();
                break;
                case 'cart':
                    $this->doCart();
                    return $this->sessionController->getXMLResponse();
                break;
            }
    }   

    public function doLogin(){
        $this->userController = new clsUser();
        $login = $this->userController->loginUser();
        return $login;
    }

    public function doRegister(){
        $this->userController = new clsUser();
        $register = $this->userController->registerUser();
        return $register;
    }

    public function doLogout(){
        $this->sessionController = new clsSession();
        $logout = $this->sessionController->logoutUser();
        return $logout;
    }

    public function doCart(){
        $this->sessionController = new clsSession();
        $cart = $this->sessionController->addToCart();
        return $cart;
    }
}

?>