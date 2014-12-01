<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassBanco
 *
 * @author CristianEduardo
 */
class ClassBanco extends EntityBase{
    var $id_banco='';
    var $descripcion='';
    
    var $acciones = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = LIMIT_RESULT)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            
        $result = $conex->prepare("SELECT count(*) AS totalCount from banco");
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rowTotal = $result->fetch();
        $result->closeCursor();
      
        $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
        $stmt->execute(array('banco', $_start, $_limit));
        $curso_array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resobj = new ClassBanco($row);
            $curso_array[] = $resobj;
        }
        
        $stmt->closeCursor();
        
        //$curso_array["acciones"] = "";
        
        return array("Bancos"=>$curso_array, "totalCount"=>$rowTotal["totalCount"]);
    
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    
    }
    
    public static function ingresarDatos($_descripcion=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codBancoReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_banco(@banco_id,:descripcion)");
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @banco_id AS bancoIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codBancoReturn = $r['bancoIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codBancoReturn;
        
    }
    
    public static function actualizarDatos($_id_banco='',$_descripcion=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_banco(:id_banco,:descripcion);");
            $stmt->bindParam(':id_banco', $_id_banco, PDO::PARAM_STR);
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
            $stmt = $conex->prepare("call eliminar_banco(:codigo);");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
