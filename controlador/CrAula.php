<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassAula.php';

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
    
       $aula_obj = ClassAula::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $aula_obj["totalCount"],
        "iTotalDisplayRecords" => $aula_obj["totalCount"],
        "aaData" => $aula_obj["Aulas"]
        ));
    }
    break;

    case "insertar":
    {
        $n_aula = $_POST["n_aula"];
        $aforo = $_POST["aforo"];
        $var_code=ClassAula::ingresarDatos($n_aula, $aforo);
        echo json_encode(array("codigo_aula" => $var_code));
    }
    break;

    case "actualizar":
    {
        $id_aula=$_POST["id_aula"];
        $n_aula=$_POST["n_aula"];
        $aforo=$_POST["aforo"];
        $var_code= ClassAula::actualizarDatos($id_aula, $n_aula, $aforo);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $id_aula=$_POST["id_aula"];
        $var_code= ClassAula::eliminarDatos($id_aula);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    default:
        break;
}

