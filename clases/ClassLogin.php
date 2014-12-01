<?php
require '../clases/ClassConexion.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author CristianEduardo
 */
class ClassLogin {
    
    var $usuario;
    var $password;
    var $conect;
    
    public function __construct($_usuario, $_password)
    {
        $this->usuario = $_usuario;
        $this->password = $_password;
        $this->conect = new ClassConexion();
    }
    
    public function validarCredenciales(){
        
        try{
            $obj_conect = $this->conect->conec;
            /*
            $sql = "select * from usuario where login='$this->usuario' and clave='$this->password'";
            if ($resultado = $obj_conect->query($sql)) {
                if ($resultado->rowCount() > 0) {
                    if(isset($_SESSION['userid'])){  $this->salir();}
                    foreach ($resultado as $row){
                          $_SESSION['userid'] = $row["id_usuario"];
                        }
                    return "1";
                }
                else{
                    return "0";
                }
            }
             */
            if(isset($_SESSION['userid'])){  $this->salir();}
            $stmt = $obj_conect->prepare("CALL logeo('$this->usuario', '$this->password')");
            $stmt->execute();
            if($stmt->rowCount() > 0){
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                  session_start();
                  $_SESSION['user'] = $rs;
                }
                return "1";
            }
            else{
                    return "0";
                }
        }
        catch(Exception $ex){
          return $ex->getMessage();
        }
    }
    
    public function salir(){
        unset($_SESSION['user']);
        session_destroy();
    }
}
