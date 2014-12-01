<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassFacultad.php';

switch ($_GET["opcion"]) {
    case "listar":
    {
       $_start = $_GET['iDisplayStart']*1;
       $_limit = $_GET['iDisplayLength']*1;
    
       $facultad_obj = ClassFacultad::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $curso_obj["totalCount"],
        "iTotalDisplayRecords" => $curso_obj["totalCount"],
        "aaData" => $facultad_obj["facultades"]
        ));
    }
    break;

    case "listar_combo":
    {
       $facultad_obj = ClassFacultad::getByFields();
       
       echo json_encode(array(
        "facultades" => $facultad_obj["facultades"]
        ));
    }
    break;
}

?>

