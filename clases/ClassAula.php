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
class ClassAula extends EntityBase{
    var $id_aula='';
    var $n_aula='';
    var $aforo='';
    
    var $acciones = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = LIMIT_RESULT)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            
        $result = $conex->prepare("SELECT count(*) AS totalCount from aula");
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rowTotal = $result->fetch();
        $result->closeCursor();
      
        $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
        $stmt->execute(array('aula', $_start, $_limit));
        $curso_array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resobj = new ClassAula($row);
            $curso_array[] = $resobj;
        }
        
        $stmt->closeCursor();
        
        //$curso_array["acciones"] = "";
        
        return array("Aulas"=>$curso_array, "totalCount"=>$rowTotal["totalCount"]);
    
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    
    }
    
    public static function ingresarDatos($_n_aula='', $_aforo=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codAulaReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_aula(@aula_id,:n_aula,:aforo)");
            $stmt->bindParam(':n_aula', $_n_aula, PDO::PARAM_STR);
            $stmt->bindParam(':aforo', $_aforo, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @aula_id AS aulaIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codAulaReturn = $r['aulaIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codAulaReturn;
        
    }
    
    public static function actualizarDatos($_id_aula='',$_n_aula='',$_aforo=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_aula(:id_aula,:n_aula,:aforo)");
            $stmt->bindParam(':id_aula', $_id_aula, PDO::PARAM_STR);
            $stmt->bindParam(':n_aula', $_n_aula, PDO::PARAM_STR);
            $stmt->bindParam(':aforo', $_aforo, PDO::PARAM_STR);
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
            $stmt = $conex->prepare("call eliminar_aula(:codigo)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
