<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassEstMencion.php';

switch ($_GET["opcion"]) {
    
    case "listar_combo":
    {
       $est_mencion_obj = ClassEstMencion::getByFields();
       
       echo json_encode(array(
        "est_menciones" => $est_mencion_obj["est_menciones"]
        ));
    }
    break;
}