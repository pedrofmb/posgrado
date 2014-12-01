<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of conexion
 *
 * @author CristianEduardo
 */
class ClassConexion {
    var $conec = "";
    var $host = "";
    var $puerto = 0;
    var $base_datos_nombre = "";
    var $base_datos_usuario = "";
    var $base_datos_password = "";
    
    public function __construct() {
        $this->host = "bdposgrado.db.10758188.hostedresource.com";
        $this->puerto = "3306";
        $this->base_datos_nombre = "bdposgrado";
        $this->base_datos_usuario = "bdposgrado";
        $this->base_datos_password = "SysGra@5445";
        
        try {
        $this->conec = new PDO('mysql:host='.$this->host.';port='.$this->puerto.';dbname='.$this->base_datos_nombre, 
                $this->base_datos_usuario, 
                $this->base_datos_password, 
                array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch (PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
