<?php

include_once __DIR__."/com/clsRequest.php";
include_once __DIR__."/com/clsServerApi.php";
include_once __DIR__."/com/clsXMLUtils.php";
include_once __DIR__."/com/clsParams.php";
include_once __DIR__."/com/clsMethod.php";
include_once __DIR__."/com/clsResponse.php";
include_once __DIR__."/com/clsErrors.php";
include_once __DIR__."/env/configuration.php";
include_once __DIR__."/DB_Controller/clsDBUtils.php";
include_once __DIR__."/DB_Controller/clsDB.php";
include_once __DIR__."/DB_Controller/clsRequestDB.php";
include_once __DIR__."/Security_Controller/clsSecurityController.php";
include_once __DIR__."/Security_Controller/clsUser.php";
include_once __DIR__."/Security_Controller/clsSession.php";


$tiempo_inicio = microtime(true);

//////////// SI ES FALSE SACA XML, EN SU DEFECTO, SI ES TRUE SACA DEBUG ////////////

$response = new clsResponse(false);

////////////////////////////////////////////////////////////////////////////////////

$obj_request = new clsRequest();

$obj_api = new clsServerApi("xml/users/api.xml");

$result = $obj_api->Validate();

if(empty($result)){
    $security = new clsSecurityController();
    $responseDB = $security->doMethod();
} else {
    $responseDB = '';
}

$tiempo_fin = microtime(true);

$tiempo_total = $tiempo_fin - $tiempo_inicio;

$response->Init($result, $tiempo_total, $responseDB);

?>