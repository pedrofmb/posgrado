<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassEstMencion
 *
 * @author Fabian
 */
class ClassEstMencion extends EntityBase{
    
    var $id_estmencion = '';
    var $descripcion = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = 0)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
           
            $result = $conex->prepare("SELECT count(*) AS totalCount from est_mencion");
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $rowTotal = $result->fetch();
            $result->closeCursor();

            if($_limit == 0) {$_limit = $rowTotal["totalCount"];}

            $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
            $stmt->execute(array('est_mencion', $_start, $_limit));
            $est_mencion_array=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resobj = new ClassEstMencion($row);
                $est_mencion_array[] = $resobj;
            }

            $stmt->closeCursor();

            return array("est_menciones"=>$est_mencion_array, "totalCount"=>$rowTotal["totalCount"]);
    
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    
    }
}
