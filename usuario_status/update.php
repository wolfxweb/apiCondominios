<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/usuario_status.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$usuario_status = new Usuario_Status($db);

$data = json_decode(file_get_contents("php://input"));
$usuario_status->usus_id = $data->usus_id;

if(!isEmpty($data->usus_nome)
&&!isEmpty($data->usus_sigla)){

if(!isEmpty($data->usus_nome)) { 
$usuario_status->usus_nome = $data->usus_nome;
} else { 
$usuario_status->usus_nome = 'Ativo';
}
if(!isEmpty($data->usus_sigla)) { 
$usuario_status->usus_sigla = $data->usus_sigla;
} else { 
$usuario_status->usus_sigla = 'A';
}
if($usuario_status->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update usuario_status","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update usuario_status. Data is incomplete.","document"=> ""));
}
?>