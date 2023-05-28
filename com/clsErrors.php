<?php

class clsErrors{

    public $num_error;
    public $message_error;
    public $severity;
    public $user_message;
    private $arrErrores = [];

    function __construct($errors, $text){
        $this->defineError($errors, $text);
    }

    private function defineError($error, $text){
        $texto = strtoupper($text);
        $this->num_error = $error;
            switch ($error){
                case 1:
                    $this->message_error = 'ACTION ERROR';
                    $this->severity = 'ALTA';
                    $this->user_message = 'EL METODO INTRODUCIDO NO EXISTE';
                    break;
                case 2:
                    $this->message_error = 'METHOD ERROR';
                    $this->severity = 'MEDIO';
                    $this->user_message = 'EL METODO '.$texto.' ES INCORRECTO';
                    break;
                case 3:
                    $this->message_error = 'FIELD ERROR';
                    $this->severity = 'MEDIO';
                    $this->user_message = 'EL CAMPO '.$texto.' ES INCORRECTO O NO EXISTE';
                    break;
                case 4:
                    $this->message_error = 'MANDATORY ERROR';
                    $this->severity = 'BAJO';
                    $this->user_message = 'EL CAMPO '.$texto.' ES OBLIGATORIO';
                    break;
                case 5:
                    $this->message_error = 'TYPE ERROR';
                    $this->severity = 'BAJO';
                    $this->user_message = 'EL TEXTO '.$texto.' TIENE QUE SER STRING';
                    break;
                case 6:
                    $this->message_error = 'MIN LENGHT ERROR';
                    $this->severity = 'BAJO';
                    $this->user_message = 'EL CAMPO '.$texto.' TIENE QUE TENER MAS CARACTERES PORFAVOR';
                    break;
            }
    }   
}

?>