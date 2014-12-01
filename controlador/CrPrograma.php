<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassPrograma.php';

switch ($_GET["opcion"]) {
    case "listar":
    {
       $_start = $_GET['iDisplayStart']*1;
       $_limit = $_GET['iDisplayLength']*1;
    
       $curso_obj = ClassPrograma::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $curso_obj["totalCount"],
        "iTotalDisplayRecords" => $curso_obj["totalCount"],
        "aaData" => $curso_obj["programas"]
        ));
    }
    break;

    case "insertar":
    {
        $nom_programa = $_POST["nom_programa"];
        $id_facultad = $_POST["id_facultad"];
        $var_code=  ClassPrograma::ingresarDatos($nom_programa, $id_facultad);
        echo json_encode(array("codigo_programa" => $var_code));
    }
    break;

    case "actualizar":
    {
        $id_programa=$_POST["id_programa"];
        $nom_programa=$_POST["nom_programa"];
        $id_facultad=$_POST["id_facultad"];
        $var_code=  ClassPrograma::actualizarDatos($id_programa, $nom_programa, $id_facultad);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $codigo=$_POST["id_programa"];
        $var_code= ClassPrograma::eliminarDatos($codigo);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "listar_combo":
    {
       $programa_obj = ClassPrograma::getByFields();
       
       echo json_encode(array(
        "programas" => $programa_obj["programas"]
        ));
    }
    break;  
}

?>

