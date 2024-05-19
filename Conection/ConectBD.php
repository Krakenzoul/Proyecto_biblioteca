<?php 
class ConexionBDPDO {
    private $host = "127.0.0.1";
    private $bd = "p_biblioteca";
    private $usuario = "root";
    private $clave = "";
  
    function conectar()
    {
        try
        {
            $conexion = new PDO("mysql:host=".$this->host.";dbname=".$this->bd.";charset=utf8", $this->usuario, $this->clave);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conexion;
        } catch (PDOException $error) {
            echo "no se conecta";
            echo 'Error conexion: ' . $error->getMessage();
            exit;
        }
    }
}
