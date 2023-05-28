<?php

class clsResponse{

    private $typeResponse;
    static public $responseHeader;
    private $timeExecute;
    private $security;

    function __construct($responseType){
        Self::$responseHeader = $responseType;
    }

    function Init($pResponse, $timeTotal, $pSecurity){
        $this->typeResponse = $pResponse;
        $this->timeExecute = $timeTotal;
        $this->security = $pSecurity;
        $this->SelectResponse();
    }

    function SelectResponse(){
        if(clsResponse::$responseHeader == false) {
            $this->echoAsXML();
        }
    }

    static function debugFunction($value){
        if(clsResponse::$responseHeader == true) {
            switch(gettype($value)){
                case 'string':
                    echo $value;
                    echo '<br>';
                    echo '<br>';
                break;
                case 'object':
                    var_dump($value);
                    echo '<br>';
                    echo '<br>';
                break;
                case 'array':
                    print_r($value);
                    echo '<br>';
                    echo '<br>';
                break;
            }
        }
    }

    public function setServerId(){
        $getServerId = '33';
        $serverId = '<server_id>'.$getServerId.'</server_id>';
        return $serverId;
    }

    public function setServerTime(){
        $getServerTime = date("Y-m-d H:i:s");
        $serverTime = '<server_time>'.$getServerTime.'</server_time>';
        return $serverTime;
    }

    public function setExecutionTime(){
        $timeExecution = round(strval($this->timeExecute),4);
        $strTimeExec = '<execution_time>'.$timeExecution.'</execution_time>';
        return $strTimeExec;
    }

    public function setUrl(){
        $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $urlP = htmlentities($url);
        $strUrl = '<url>'.$urlP.'</url>';
        return $strUrl;
    }

    public function setParams(){
        $params = $_GET;
        $strMethod = '<webmethod>';

        foreach($params as $key => $value){
            if($key == 'action'){
                $strMethod.= '<name>'.$value.'</name><parameters>';
            } else {
                $strMethod .= '<parameter>
                <name>'.$key.'</name>
                <value>'.$value.'</value>

                </parameter>';
            }
        }
        return $strMethod.'</parameters></webmethod>';
    }

    public function setErrors(){
        $strErrors = '<errors>';
        foreach($this->typeResponse as $errores){
            $strErrors .= '<error>
            <num_error>'.$errores->num_error.'</num_error>
            <message_error>'.$errores->message_error.'</message_error>
            <severity>'.$errores->severity.'</severity>
            <user_message>'.$errores->user_message.'</user_message>
            </error>';
        }
        return $strErrors.'</errors>';
    }

    public function setResponseData(){
        return $this->security;
    }

    public function echoAsXML(){
        header("Content-type: text/xml");
        $id = $this->setServerId();
        $date = $this->setServerTime();
        $time = $this->setExecutionTime();
        $url = $this->setUrl();
        $errors = $this->setErrors();
        $params = $this->setParams();
        $body = $this->setResponseData();
        $xmlTag = <<<XML
        <ws_response>
            <header>
                $id
                $date
                $time
                $url
                $params
                $errors
            </header>
            <body>
                <response_data>$body</response_data>
            </body>
        </ws_response>
        XML;
        $xmlTag = new SimpleXMLElement($xmlTag);
        echo $xmlTag->asXML();
    }
}

?>