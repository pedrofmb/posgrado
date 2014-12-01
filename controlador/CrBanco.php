<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassBanco.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
switch ($_GET["opcion"]) {
    case "listar":
    {
       $_start = $_GET['iDisplayStart']*1;
       $_limit = $_GET['iDisplayLength']*1;
    
       $banco_obj = ClassBanco::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $banco_obj["totalCount"],
        "iTotalDisplayRecords" => $banco_obj["totalCount"],
        "aaData" => $banco_obj["Bancos"]
        ));
    }
    break;

    case "insertar":
    {
        $descripcion = $_POST["descripcion"];
        $var_code=ClassBanco::ingresarDatos($descripcion);
        echo json_encode(array("codigo_banco" => $var_code));
    }
    break;

    case "actualizar":
    {
        $id_banco=$_POST["id_banco"];
        $descripcion=$_POST["descripcion"];
        $var_code= ClassBanco::actualizarDatos($id_banco, $descripcion);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $id_banco=$_POST["id_banco"];
        $var_code= ClassBanco::eliminarDatos($id_banco);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    default:
        break;
}

