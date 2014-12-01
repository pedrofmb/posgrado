<?php
session_start();

require_once '../clases/ClassConexion.php';
require_once '../utiles/EntityBase.php';
require_once '../clases/ClassDocente.php';

require_once '../utiles/Fecha.php';

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
    
       $docente_obj = ClassDocente::getByFields($_start, $_limit);
       
       echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $docente_obj["totalCount"],
        "iTotalDisplayRecords" => $docente_obj["totalCount"],
        "aaData" => $docente_obj["Docentes"]
        ));
    }
    break;

    case "insertar":
    {
        $dni = $_POST["dni"];
        $apellidos = $_POST["apellidos"];
        $nombres = $_POST["nombres"];
        $direccion = $_POST["direccion"];
        $id_genero = $_POST["id_genero"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $telefono = $_POST["telefono"];
        $id_estmencion = $_POST["id_estmencion"];
        $id_ciudad = $_POST["id_ciudad"];
        $email = $_POST["email"];
        
        $var_code=  ClassDocente::ingresarDatos($dni, $apellidos, $nombres, $direccion, $id_genero, $fecha_nacimiento, $telefono, $id_estmencion, $id_ciudad, $email);
        echo json_encode(array("id_docente" => $var_code));
    }
    break;

    case "modificar":
    {
        $codigo = $_POST["codigo"];
        $dni = $_POST["dni"];
        $apellidos = $_POST["apellidos"];
        $nombres = $_POST["nombres"];
        $direccion = $_POST["direccion"];
        $id_genero = $_POST["id_genero"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $telefono = $_POST["telefono"];
        $id_estmencion = $_POST["id_estmencion"];
        $id_ciudad = $_POST["id_ciudad"];
        $email = $_POST["email"];
        
        $var_code= ClassDocente::actualizarDatos($codigo, $dni, $apellidos, $nombres, $direccion, $id_genero, $fecha_nacimiento, $telefono, $id_estmencion, $id_ciudad, $email);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;

    case "eliminar":
    {
        $codigo=$_POST["codigo_docente"];
        $var_code= ClassDocente::eliminarDatos($codigo);
        echo json_encode(array("valor_estado" => $var_code));
    }
    break;
}