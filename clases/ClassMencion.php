<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassMencion
 *
 * @author CristianEduardo
 */
class ClassMencion extends EntityBase{
    var $id_mencion='';
    var $nom_mencion='';
    var $id_programa ='';
    var $nom_programa='';
    var $acciones = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = LIMIT_RESULT)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            
        $result = $conex->prepare("SELECT count(*) AS totalCount from mencion as M inner join programa as P on M.id_programa=P.id_programa");
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rowTotal = $result->fetch();
        $result->closeCursor();
      
        $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
        $stmt->execute(array('mencion', $_start, $_limit));
        $mencion_array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resobj = new ClassMencion($row);
            $mencion_array[] = $resobj;
        }
        
        $stmt->closeCursor();
        
        return array("menciones"=>$mencion_array, "totalCount"=>$rowTotal["totalCount"]);
    
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    
    }
    
    public static function ingresarDatos($_descripcion='', $_codPrograma=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codMencionReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_mencion(@mencion_id,:desc_mencion,:cod_programa)");
            $stmt->bindParam(':desc_mencion', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':cod_programa', $_codPrograma, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @mencion_id AS mencionIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codMencionReturn = $r['mencionIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codMencionReturn;
        
    }
    
    public static function actualizarDatos($_codigo='',$_descripcion='',$_codigoPrograma=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_mencion(:codigo,:descripcion,:codprograma)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':codprograma', $_codigoPrograma, PDO::PARAM_STR);
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
            $stmt = $conex->prepare("call eliminar_mencion(:codigo)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
