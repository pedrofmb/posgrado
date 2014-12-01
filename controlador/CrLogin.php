<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../clases/ClassLogin.php';

$opcion_logeo = $_POST["opcion"];
$usuario_sistema = $_POST["usuario"];
$password_sistema = $_POST["password"];


switch ($opcion_logeo) {
    case "LOGIN":
    {
        $obj_class_login = new ClassLogin($usuario_sistema, $password_sistema);
        $return = $obj_class_login->validarCredenciales();

        if($return == "1"){
            echo json_encode(array('resultado' => 'OK'));
        }
        else{
            echo json_encode(array('resultado' => 'NO', 'ERROR' => $return));
        }
    }
     break;
     
    case "LOGOUT":
    {
        $obj_class_login = new ClassLogin("", "");
        $obj_class_login->salir();
    }
    break;
    default:
        break;
}
