<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPrograma
 *
 * @author CristianEduardo
 */
class ClassPrograma extends EntityBase{
    var $id_programa='';
    var $nom_programa='';
    var $id_facultad ='';
    var $nom_facultad='';
    var $acciones = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = 0)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            
        $result = $conex->prepare("SELECT count(*) AS totalCount from programa AS P inner join facultad as F on P.id_facultad=F.id_facultad");
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rowTotal = $result->fetch();
        $result->closeCursor();
        
        if($_limit == 0) {$_limit = $rowTotal["totalCount"];}
      
        $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
        $stmt->execute(array('programa', $_start, $_limit));
        $programa_array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resobj = new ClassPrograma($row);
            $programa_array[] = $resobj;
        }
        
        $stmt->closeCursor();
        
        return array("programas"=>$programa_array, "totalCount"=>$rowTotal["totalCount"]);
    
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    
    }
    
    public static function ingresarDatos($_descripcion='', $_codFacu=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codProgramaReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_programa(@programa_id,:desc_programa,:cod_facultad)");
            $stmt->bindParam(':desc_programa', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':cod_facultad', $_codFacu, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @programa_id AS programaIden")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codProgramaReturn = $r['programaIden'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codProgramaReturn;
        
    }
    
    public static function actualizarDatos($_codigo='',$_descripcion='',$_codigoFacultad=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call editar_programa(:codigo,:descripcion,:codfacultad)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $_descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':codfacultad', $_codigoFacultad, PDO::PARAM_STR);
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
            $stmt = $conex->prepare("call eliminar_programa(:codigo)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
