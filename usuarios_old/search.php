<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/usuarios.php';
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

$usuarios = new Usuarios($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$usuarios->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$usuarios->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $usuarios->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $usuarios_arr=array();
	$usuarios_arr["pageno"]=$usuarios->pageNo;
	$usuarios_arr["pagesize"]=$usuarios->no_of_records_per_page;
    $usuarios_arr["total_count"]=$usuarios->search_count($searchKey);
    $usuarios_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $usuarios_item=array(
            
"usu_id" => $usu_id,
"usu_nome" => $usu_nome,
"usu_email" => html_entity_decode($usu_email),
"usu_password" => $usu_password,
"usu_reset_token" => $usu_reset_token,
"sta_nome" => $sta_nome,
"sta_id" => $sta_id,
"usut_id" => $usut_id
        );
        array_push($usuarios_arr["records"], $usuarios_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "usuarios found","document"=> $usuarios_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No usuarios found.","document"=> ""));
}
 


