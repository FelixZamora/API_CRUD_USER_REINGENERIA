<?php
require_once "ConDB.php";

class UserModel{

    static public function createUser($data){
        $cantMail = self::getMail($data["use_mail"]);
        if($cantMail == 0){
            $query = "INSERT INTO users(use_id, use_mail, use_pss, use_dateCreate, us_identifier, us_key, us_status) 
            VALUES (NULL, :use_mail, :use_pss, :use_dateCreate, :us_identifier, :us_key, :us_status)";
            $status="0";
            $stament = Conection::connection()->prepare($query);
            $stament->bindParam(":use_mail", $data["use_mail"], PDO::PARAM_STR);
            $stament->bindParam(":use_pss", $data["use_pss"], PDO::PARAM_STR);
            $stament->bindParam(":use_dateCreate", $data["use_dateCreate"], PDO::PARAM_STR);
            $stament->bindParam(":us_identifier", $data["us_identifier"], PDO::PARAM_STR);
            $stament->bindParam(":us_key", $data["us_key"], PDO::PARAM_STR);
            $stament->bindParam(":us_status", $status, PDO::PARAM_STR);
            $message = $stament -> execute() ? "Se ha creado el usuario correctamente" : Conection::connection() -> errorInfo();
            $stament -> closeCursor();
            $stament = null;
            $query = "";
        }
        else{
            $message = "Usuario ya esta registrado";
        }
        return $message;
    }
    //Metodo para verificar si existe ese correo en la BD
    static private function getMail($mail){
        $query = "";
        $query = "SELECT use_mail FROM users WHERE use_mail = '$mail';";
        $stament = Conection::connection()->prepare($query);
        $stament->execute();
        $result = $stament->rowCount();
        return $result;
    }
    //TRAE TODOS LOS USUARIOS
    static function getUsers($id){
        $query = "";
        $id = is_numeric($id) ? $id : 0;
        $query = "SELECT use_id, use_mail, use_dateCreate FROM users";
        $query.=($id > 0) ? " WHERE users.use_id = '$id' AND " : "";
        $query.=($id > 0) ? " us_status='1';" : " WHERE us_status = '1';";
        //echo $query;   
        $stament = Conection::connection()->prepare($query);
        $stament->execute();
        $result = $stament->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //TRAE TODOS LOS USUARIOS SIN DEPENDER DEL STATUS
    static function getUsersStatus($id){
        $id = is_numeric($id) ? $id : 0;
    
        $query = "SELECT use_id, use_mail, use_dateCreate FROM users";
        $query .= ($id > 0) ? " WHERE use_id = :use_id" : "";
    
        $stament = Conection::connection()->prepare($query);
    
        if ($id > 0) {
            $stament->bindParam(":use_id", $id, PDO::PARAM_INT);
        }
    
        $stament->execute();
        $result = $stament->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    
    //Login
    static public function login($data){
        //$query = "";
        $user = $data['use_mail'];
        $pss = $data['use_pss'];
        //echo $pss
        if(!empty($user) && !empty($pss)){
            $query = "SELECT us_identifier, us_key, use_id FROM users WHERE use_mail='$user' and use_pss = '$pss' and us_status = '1'";
            $stament = Conection::connection()->prepare($query);
            $stament->execute();
            $result = $stament->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        else{
            $mensaje = array(
                "COD" => "001",
                "MENSAJE" => ("Error en credenciales")
            );
            return $mensaje;
        }
        $query="";
    }

    //Eliminar usuario activo -> status = 1
    static function deleteUser($data){
        $id = $data['use_id'];
        $id = is_numeric($id) ? $id : 0;
        $userExists = self::getUsers($id);
        
        if (!empty($userExists)) {
            $query = "DELETE FROM users WHERE use_id = '$id'";
            
            $stament = Conection::connection()->prepare($query);
            $stament->execute();
            $result = $stament->fetchAll(PDO::FETCH_ASSOC);
            $message = $stament -> execute() ? "Se ha eliminado el usuario correctamente" : Conection::connection() -> errorInfo();
            return $message;

        } else {
            $mensaje = array(
                "COD" => "010",
                "MENSAJE" => ("No se encrontró el usuario")
            );
            return $mensaje;
        }
        $query="";
    }

    //Actualizar usuario activo -> status = 1

    static function updateUser($data){
        $id = $data['use_id'];
        $mail = $data['use_mail'];
        $pss = $data['use_pss'];
        $id = is_numeric($id) ? $id : 0;
        
        // Verificar si el usuario existe antes de intentar actualizarlo
        $userExists = self::getUsers($id);
        
        if (!empty($userExists)) {
            // El usuario existe, proceder con la actualización
            $query = "UPDATE users 
                      SET use_mail = :use_mail, 
                          use_pss = :use_pss
                      WHERE use_id = :use_id";
    
            $stament = Conection::connection()->prepare($query);
            $stament->bindParam(":use_mail", $data["use_mail"], PDO::PARAM_STR);
            $stament->bindParam(":use_pss", $data["use_pss"], PDO::PARAM_STR);
            $stament->bindParam(":use_id", $id, PDO::PARAM_INT);
            
            $message = $stament->execute() ? "Se ha actualizado el usuario correctamente" : Conection::connection()->errorInfo();
            
            $stament->closeCursor();
            $stament = null;
    
            return $message;
        } else {
            // El usuario no existe
            $mensaje = array(
                "COD" => "015",
                "MENSAJE" => "No se encontró el usuario"
            );
            return $mensaje;
        }
    }

    //Actualizar STATUS -> status = 1

    static function updateStatus($data){
        $id = $data['use_id'];
        $status = $data['us_status'];
        $id = is_numeric($id) ? $id : 0;
        $status = is_numeric($status) ? $status : 0;
        $userExists = self::getUsersStatus($id);
        
        // Verificar si el usuario existe antes de intentar actualizarlo
        
        if ($id != 0 && ($status == 0 || $status == 1) && !empty($userExists)) {
            // El usuario existe, proceder con la actualización
            $query = "UPDATE users 
                      SET us_status = :us_status 
                      WHERE use_id = :use_id";
    
            $stament = Conection::connection()->prepare($query);
            $stament->bindParam(":us_status", $data["us_status"], PDO::PARAM_STR);
            $stament->bindParam(":use_id", $id, PDO::PARAM_INT);
            
            $message = $stament->execute() ? "Se ha actualizado el status del usuario" : Conection::connection()->errorInfo();
            
            $stament->closeCursor();
            $stament = null;
    
            return $message;
        } else {
            // El usuario no existe
            $mensaje = array(
                "COD" => "016",
                "MENSAJE" => "No se encontró el usuario"
            );
            return $mensaje;
        }
    }    
    
    //Autentificador
    static public function getUserAuth(){
        $query="";
        $query="SELECT us_identifier,us_key FROM users WHERE us_status = '1';";
        $stament = Conection::connection()->prepare($query);
        $stament->execute();
        $result = $stament->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}


?>