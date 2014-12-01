<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassCiudad.php';

switch ($_GET["opcion"]) {
    
    case "listar_combo":
    {
       $ciudad_obj = ClassCiudad::getByFields();
       
       echo json_encode(array(
        "ciudades" => $ciudad_obj["ciudades"]
        ));
    }
    break;

    case "listar":
    {
       $_start = $_GET['iDisplayStart']*1;
       $_limit = $_GET['iDisplayLength']*1;
    
       $ciudad_obj = ClassCiudad::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $ciudad_obj["totalCount"],
        "iTotalDisplayRecords" => $ciudad_obj["totalCount"],
        "aaData" => $ciudad_obj["ciudades"]
        ));
    }
    break;

    case "insertar":
    {
        $descripcion = $_POST["descripcion"];
        $var_code=ClassCiudad::ingresarDatos($descripcion);
        echo json_encode(array("codigo_ciudad" => $var_code));
    }
    break;

    case "actualizar":
    {
        $id_ciudad=$_POST["id_ciudad"];
        $descripcion=$_POST["descripcion"];
        $var_code= ClassCiudad::actualizarDatos($id_ciudad, $descripcion);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $id_ciudad=$_POST["id_ciudad"];
        $var_code= ClassCiudad::eliminarDatos($id_ciudad);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    default:
        break;
}