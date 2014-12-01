<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassCurso.php';

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
    
       $curso_obj = ClassCurso::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $curso_obj["totalCount"],
        "iTotalDisplayRecords" => $curso_obj["totalCount"],
        "aaData" => $curso_obj["cursos"]
        ));
    }
    break;

    case "insertar":
    {
        $descripcion = $_POST["descripcion"];
        $creditos = $_POST["creditos"];
        $var_code=ClassCurso::ingresarDatos($descripcion, $creditos);
        echo json_encode(array("codigo_curso" => $var_code));
    }
    break;

    case "actualizar":
    {
        $codigo=$_POST["codigo"];
        $descripcion=$_POST["descripcion"];
        $creditos=$_POST["creditos"];
        $var_code=  ClassCurso::actualizarDatos($codigo, $descripcion, $creditos);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $codigo=$_POST["codigo"];
        $var_code= ClassCurso::eliminarDatos($codigo);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    default:
        break;
}
