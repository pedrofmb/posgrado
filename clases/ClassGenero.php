<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassGenero
 *
 * @author Fabian
 */
class ClassGenero extends EntityBase{
    
    var $id_genero = '';
    var $genero = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = 0)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
           
            $result = $conex->prepare("SELECT count(*) AS totalCount from genero");
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $rowTotal = $result->fetch();
            $result->closeCursor();

            if($_limit == 0) {$_limit = $rowTotal["totalCount"];}

            $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
            $stmt->execute(array('genero', $_start, $_limit));
            $genero_array=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resobj = new ClassGenero($row);
                $genero_array[] = $resobj;
            }

            $stmt->closeCursor();

            return array("generos"=>$genero_array, "totalCount"=>$rowTotal["totalCount"]);
    
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    
    }
}
