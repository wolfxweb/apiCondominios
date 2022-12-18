<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/documentos.php';
include_once '../token/validatetoken.php';

if (isset($decodedJWTData) && isset($decodedJWTData->tenant))
{
$database = new Database($decodedJWTData->tenant); 
}
else 
{
$database = new Database(); 
}

$db = $database->getConnection();

$documentos = new Documentos($db);

$data = json_decode(file_get_contents("php://input"));

$documentos->id = $data->id;


if($documentos->delete()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Documentos was deleted","document"=> ""));
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete documentos.","document"=> ""));
}
?>
