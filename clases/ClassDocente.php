<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassDocente
 *
 * @author Fabian
 */
class ClassDocente extends EntityBase{
    
    var $id_docente ='';
    var $dni = '';
    var $apellidos = '';
    var $nombres = '';
    var $direccion = '';
    var $id_genero = '';
    var $f_nac = '';
    var $telefono = '';
    var $id_estmencion = '';
    var $id_ciudad = '';
    var $email = '';
    var $genero = '';
    var $em_descripcion = '';
    var $ciudad_descripcion = '';
    
    var $accion_modificar = '';
    var $accion_eliminar = '';
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public static function getByFields($_start = 0, $_limit = 0)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
            try {
            $result = $conex->prepare("SELECT COUNT(*) AS totalCount FROM docente D 
                                       INNER JOIN genero G ON D.id_genero = G.id_genero
                                       INNER JOIN est_mencion EM ON D.id_estmencion = EM.id_estmencion
                                       INNER JOIN ciudad C ON D.id_ciudad = C.id_ciudad");
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $rowTotal = $result->fetch();
            $result->closeCursor();
            
            if($_limit == 0) {$_limit = $rowTotal["totalCount"];}

            $stmt = $conex->prepare("CALL listar_intervalo(?,?,?)");
            $stmt->execute(array('docente', $_start, $_limit));
            $curso_array=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resobj = new ClassDocente($row);
                $curso_array[] = $resobj;
            }

            $stmt->closeCursor();
            return array("Docentes"=>$curso_array, "totalCount"=>$rowTotal["totalCount"]);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
    
    }
    
    public static function ingresarDatos($_dni, $_apellidos, $_nombres, $_direccion, $_id_genero, $_f_nac, $_telefono, $_id_estmencion, $_id_ciudad, $_email)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        $codDocenteReturn='';
        
        try {
            
            $stmt = $conex->prepare("CALL crear_docente(@id_docente, :dni, :apellidos, :nombres, :direccion, :id_genero, :fecha_nacimiento, :telefono, :id_estmencion, :id_ciudad, :email)");
            $stmt->bindParam(':dni', $_dni, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $_apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':nombres', $_nombres, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $_direccion, PDO::PARAM_STR);
            $stmt->bindParam(':id_genero', $_id_genero, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $_f_nac, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $_telefono, PDO::PARAM_STR);
            $stmt->bindParam(':id_estmencion', $_id_estmencion, PDO::PARAM_STR);
            $stmt->bindParam(':id_ciudad', $_id_ciudad, PDO::PARAM_STR);
            $stmt->bindParam(':email', $_email, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $r = $conex->query("SELECT @id_docente AS id_docente")->fetch(PDO::FETCH_ASSOC);
            if ($r) {
                $codDocenteReturn = $r['id_docente'];
            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
        return $codDocenteReturn;
        
    }
    
    public static function actualizarDatos($_codigo, $_dni, $_apellidos, $_nombres, $_direccion, $_id_genero, $_f_nac, $_telefono, $_id_estmencion, $_id_ciudad, $_email)
    {
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        
        try {
            
            $stmt = $conex->prepare("CALL editar_docente(:id_docente, :dni, :apellidos, :nombres, :direccion, :id_genero, :fecha_nacimiento, :telefono, :id_estmencion, :id_ciudad, :email)");
            $stmt->bindParam(':id_docente', $_codigo, PDO::PARAM_STR);
            $stmt->bindParam(':dni', $_dni, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $_apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':nombres', $_nombres, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $_direccion, PDO::PARAM_STR);
            $stmt->bindParam(':id_genero', $_id_genero, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $_f_nac, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $_telefono, PDO::PARAM_STR);
            $stmt->bindParam(':id_estmencion', $_id_estmencion, PDO::PARAM_STR);
            $stmt->bindParam(':id_ciudad', $_id_ciudad, PDO::PARAM_STR);
            $stmt->bindParam(':email', $_email, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
        }
        
    }
    
    public static function eliminarDatos($_codigo=''){
        $PDO_obj = new ClassConexion();
        $conex = $PDO_obj->conec;
        try{
            $stmt = $conex->prepare("call eliminar_docente(:codigo)");
            $stmt->bindParam(':codigo', $_codigo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount();
            
        } catch (PDOException $ex) {
            echo 'Error: '.$ex->getMessage();
        }
    }
}
