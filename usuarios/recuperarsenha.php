<?php

include_once '../config/header.php';

include_once '../objects/usuarios.php';


$data = json_decode(file_get_contents("php://input"));

$user = new Usuarios($data);

if(empty($data->usu_email)){
    $user->responseError("email");
    return false;
}

if(!empty($data->usu_email) ){
    $user->recuperarSenha();
}else{
    $user->responseError("");
    return false;
}