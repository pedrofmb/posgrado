<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassMencion.php';

switch ($_GET["opcion"]) {
    case "listar":
    {
       $_start = $_GET['iDisplayStart']*1;
       $_limit = $_GET['iDisplayLength']*1;
    
       $curso_obj = ClassMencion::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $curso_obj["totalCount"],
        "iTotalDisplayRecords" => $curso_obj["totalCount"],
        "aaData" => $curso_obj["menciones"]
        ));
    }
    break;

    case "insertar":
    {
        $nom_mencion = $_POST["nom_mencion"];
        $id_programa = $_POST["id_programa"];
        $var_code= ClassMencion::ingresarDatos($nom_mencion, $id_programa);
        echo json_encode(array("codigo_mencion" => $var_code));
    }
    break;

    case "actualizar":
    {
        $id_mencion=$_POST["id_mencion"];
        $nom_mencion=$_POST["nom_mencion"];
        $id_programa=$_POST["id_programa"];
        $var_code=  ClassMencion::actualizarDatos($id_mencion, $nom_mencion, $id_programa);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $codigo=$_POST["id_mencion"];
        $var_code= ClassMencion::eliminarDatos($codigo);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;
}

?>

