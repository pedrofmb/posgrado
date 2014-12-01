<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassGenero.php';

switch ($_GET["opcion"]) {
    
    case "listar_combo":
    {
       $genero_obj = ClassGenero::getByFields();
       
       echo json_encode(array(
        "generos" => $genero_obj["generos"]
        ));
    }
    break;
}