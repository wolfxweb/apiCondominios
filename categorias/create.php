<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/categorias.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$categorias = new Categorias($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->cat_id)
&&!isEmpty($data->cat_nome)){
	
    
if(!isEmpty($data->cat_id)) { 
$categorias->cat_id = $data->cat_id;
} else { 
$categorias->cat_id = '';
}
if(!isEmpty($data->cat_nome)) { 
$categorias->cat_nome = $data->cat_nome;
} else { 
$categorias->cat_nome = '';
}
$categorias->cat_descricao = $data->cat_descricao;
$categorias->cat_padrao = $data->cat_padrao;
$categorias->cat_img_url = $data->cat_img_url;
 	$lastInsertedId=$categorias->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create categorias","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create categorias. Data is incomplete.","document"=> ""));
}
?>