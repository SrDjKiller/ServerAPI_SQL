<?php

class clsMethod{

    private $xml_node;
    private $obj_xmlutil;
    private $description;
    private $endpoint;
    private $paramsCollection;
    private $action;
    private $arrayParams = [];
    private $result = [];

    function __construct($pNode){
        $this->xml_node=$pNode;
        $this->description = $this->xml_node[0]->description;
        $this->endpoint = $this->xml_node[0]->endpoint;
        $this->paramsCollection = $this->xml_node[0]->params_collection;
        $this->Init();
    }

    function Init(): void{
        $this->ParseMethodParams();
    }

    function ParseMethodParams(){
        foreach($this->paramsCollection as $params){
            foreach($params as $param){
                if($param["name"]=='action'){
                    $this->AddAction($param);
                }else{
                    $this->AddParam($param);
                }
            }
        }
    }

    function AddParam($data){
        $obj_method = new clsParams($data);
        array_push($this->arrayParams,$obj_method);
    }

    function AddAction($data){
        $this->action = $data->default;
    }

    public function ValidarAction($value){
        if($value == $this->action){
            foreach($this->arrayParams as $param){
                $resultParam = $param->ValidateAttributes();
                if($resultParam != 0){
                    $this->result = array_merge($this->result,$resultParam);
                }
            }
            return $this->result;
        }
        return false;
    }
}   

?>