<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/migrations.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$migrations = new Migrations($db);

$migrations->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$migrations->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $migrations->read();
$num = $stmt->rowCount();
if($num>0){
    $migrations_arr=array();
	$migrations_arr["pageno"]=$migrations->pageNo;
	$migrations_arr["pagesize"]=$migrations->no_of_records_per_page;
    $migrations_arr["total_count"]=$migrations->total_record_count();
    $migrations_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $migrations_item=array(
            
"id" => $id,
"migration" => html_entity_decode($migration),
"batch" => $batch
        );
         array_push($migrations_arr["records"], $migrations_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "migrations found","document"=> $migrations_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No migrations found.","document"=> ""));
}
 

