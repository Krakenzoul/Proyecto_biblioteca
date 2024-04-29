<?php 
    $server="127.0.0.1";
    $data_base_name="bd_biblioteca";
    $user="root";
    $password="0426";

    try {
        $conexionpdo = new PDO("mysql:host=$server;dbname=$data_base_name",$user,$password);
        }
        catch (PDOException $e){
        echo $e->getMessage();
        }
?>