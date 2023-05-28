<?php

class clsRequest{

/////////////////////////////////////////////////////
    static function Exists($key){
        if (isset($_GET[$key])){
            return true;
        }else{
            return false;
        }
    }
/////////////////////////////////////////////////////
    static function GetValue($key){
            return $_GET[$key];
    }
}

?>