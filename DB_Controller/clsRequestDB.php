<?php

include_once "./interfaces/ControllerDataBaseInterface.php";

class clsRequestDB implements ControllerDataBaseInterface{
    
    private $db;
    private $request;
    private $procedureResponse;

    function __construct($pDB){
        $this->db = $pDB;
    }

    private function putInterrogationMarks(array $params) {
        $numElementos = count($params);
        $interrogaciones = str_repeat('?,', $numElementos - 1) . '?';
        return $result = "EXEC ? $interrogaciones";
    }

    private function bindParamsToProcedure(string $name, array $params): void{
        $this->request->bindParam(1, $name, PDO::PARAM_STR);
        for($i=0; $i < count($params);$i++){
            $this->request->bindParam($i+2, $params[$i]);
        }
    }

    public function prepareProcedure(string $name_procedure, array $params=[]): void {
        if (count($params) == 0) {
            $this->request = $this->db->prepare('EXEC '.$name_procedure);
        }else {
            $procedure = $this->putInterrogationMarks($params);
            $this->request = $this->db->prepare($procedure);
            $this->bindParamsToProcedure($name_procedure, $params);
        }
    }

    public function executeProcedure(): void {
        $this->request->execute();
    }

    public function fetchExecutionProcedure(): void {
        if ($this->request->rowCount() === 1) {
            $this->request->nextRowset();
        }
        $this->procedureResponse = $this->request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataXMLString(){
        foreach($this->procedureResponse[0] as $xml){
            $str_xml = $xml;
        }
        return $str_xml;
    }

    public function getDataXML(){
        foreach($this->procedureResponse[0] as $xml){
            $str_xml = $xml;
        }
        return simplexml_load_string($str_xml);
    }

    public function renderDataXML(): void {
        foreach($this->procedureResponse[0] as $xml){
            $obj_xml = simplexml_load_string($xml);
        }
         header("Content-type: text/xml");
        echo $obj_xml->asXML();
    }
}

?>