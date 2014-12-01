<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassCiudad
 *
 * @author Fabian
 */
class ClassCiudad extends EntityBase{
    
    var $id_ciudad = '';
    var $descripcion = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = 0)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
           
            $result = $conex->prepare("SELECT count(*) AS totalCount from ciudad");
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $rowTotal = $result->fetch();
            $result->closeCursor();

            if($_limit == 0) {$_limit = $rowTotal["totalCount"];}

            $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
            $stmt->execute(array('ciudad', $_start, $_limit));
            $ciudad_array=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resobj = new ClassCiudad($row);
                $ciudad_array[] = $resobj;
            }

            $stmt->closeCursor();

            return array("ciudades"=>$ciudad_array, "totalCount"=>$rowTotal["totalCount"]);
    
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    
    }
    
    public static function ingresarDatos($_descripcion=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codCiudadReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_ciudad(@ciudad_id,:descripcion)");
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @ciudad_id AS ciudadIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codCiudadReturn = $r['ciudadIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codCiudadReturn;
        
    }
    
    public static function actualizarDatos($_id_ciudad='',$_descripcion=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_ciudad(:id_ciudad,:descripcion);");
            $stmt->bindParam(':id_ciudad', $_id_ciudad, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
    
    public static function eliminarDatos($_codigo=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call eliminar_ciudad(:codigo);");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
