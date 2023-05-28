<?php

class clsParams{

    private $nombre;
    private $type;
    private $mandatory;
    private $min_lenght;
    private $infoparam;
    private $arrErrors = [];

    function __construct($parametros){
        $this->infoparam = $parametros;
        $this->Init();
    }

    function Init(){
        $this->ParseParams();
    }

    function ParseParams(){
        $this -> nombre = $this -> infoparam -> xpath('@name');
        $this->nombre =(string)$this->nombre[0]["name"];
        
        foreach($this->infoparam as $clave => $valor){
            switch ($clave) {
                case 'type':
                    $this -> type = $valor;
                    break;      
                case 'mandatory':
                    $this -> mandatory = $valor;
                    break;
                case 'min_length':
                    $this -> min_lenght = $valor;
                    break;
            }
        }
    }

    public function ValidateAttributes(){
        if(clsRequest::Exists($this->nombre)){
            $value = clsRequest::GetValue($this->nombre);
            if($this->mandatory == 'yes'){
                if($value == ''){
                    array_push($this->arrErrors ,new clsErrors(4, $this->nombre)); 
                    return $this->arrErrors;
                }
            }
            if(gettype($value) != $this->type){
                array_push($this->arrErrors ,new clsErrors(5, $this->nombre)); 
                return $this->arrErrors;
            }
            if(strlen($value) < (int)$this->min_lenght){
                array_push($this->arrErrors ,new clsErrors(6, $this->nombre)); 
                return $this->arrErrors;
            }
            return 0;
        }
        array_push($this->arrErrors ,new clsErrors(3, $this->nombre));
        return $this->arrErrors; 
    }
}

?>