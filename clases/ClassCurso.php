<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassCurso
 *
 * @author CristianEduardo
 */
class ClassCurso extends EntityBase{
    var $id_curso='';
    var $descripcion='';
    var $creditos='';
    
    var $acciones = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = LIMIT_RESULT)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            
        $result = $conex->prepare("SELECT count(*) AS totalCount from curso");
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rowTotal = $result->fetch();
        $result->closeCursor();
      
        $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
        $stmt->execute(array('curso', $_start, $_limit));
        $curso_array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resobj = new ClassCurso($row);
            $curso_array[] = $resobj;
        }
        
        $stmt->closeCursor();
        
        //$curso_array["acciones"] = "";
        
        return array("cursos"=>$curso_array, "totalCount"=>$rowTotal["totalCount"]);
    
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    
    }
    
    public static function ingresarDatos($_descripcion='', $_creditos=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codCursoReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_curso(@curso_id,:descrip,:creditos)");
            $stmt->bindParam(':descrip', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':creditos', $_creditos, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @curso_id AS cursoIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codCursoReturn = $r['cursoIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codCursoReturn;
        
    }
    
    public static function actualizarDatos($_codigo='',$_descripcion='',$_creditos=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_curso(:codigo,:descripcion,:creditos)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':creditos', $_creditos, PDO::PARAM_STR);
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
            $stmt = $conex->prepare("call eliminar_curso(:codigo)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
