<?php 
    $server="127.0.0.1";
    $data_base_name="p_biblioteca";
    $user="root";
    $password="0426";

    try {
        $conect= new PDO("mysql:host=$server;dbname=$data_base_name",$user,$password);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?>