<?php

class clsServerApi{

    private $configfile;
    private $obj_xmlutil;
    private $cls_method;
    private $arrMethods = [];
    private $arrErrors = [];
   
    function __construct($configfile){
        $this->obj_xmlutil= new clsXMLUtils;
        $this->configfile=$configfile;
        $this->Init();
    }

    function Init(){
        $this->ReadConfigurationFile();
        $this->ParseWebMethods();
    }

    function ReadConfigurationFile():void{
        $this->obj_xmlutil->ReadFile($this->configfile);
    }

    function ParseWebMethods(){
        $this->obj_xmlutil->ApplyXpath('//web_methods_collection/web_method');
        $arrM = $this->obj_xmlutil->getResult();
        foreach ($arrM as $Method) {
            $this->addMethod($this->obj_xmlutil->arraytoXML($Method));
        }
    }

    function addMethod(SimpleXMLElement $XMLMethod){
        $cls_method = new clsMethod($XMLMethod);
        array_push($this->arrMethods, $cls_method);
        clsResponse::debugFunction('--- Nº METODOS '.count($this->arrMethods).' ---');
        clsResponse::debugFunction($this->arrMethods);
    }

    public function Validate(){
        $cont=0;
        if(clsRequest::Exists('action')){
            $value = clsRequest::GetValue('action');
                foreach($this->arrMethods as $method){
                    $result=$method->ValidarAction($value);
                    if(is_bool($result)){
                        $cont++;
                    }else{
                        return $result;
                    }
                }
                if($cont == count($this->arrMethods)){
                    array_push($this->arrErrors ,new clsErrors(2, $value)); 
                    return $this->arrErrors;
                }
        }else{
            array_push($this->arrErrors ,new clsErrors(1, 'ACTION ERROR')); 
            return $this->arrErrors;
        }
    }
}

?>