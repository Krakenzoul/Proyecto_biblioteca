<?php
if (!isset($_GET["No_documento"])) {
    exit("No entra.....");
} else {
    include_once "../../Conection/ConectBD.php";
    $objdb = new ConexionBDPDO();
    $conexion = $objdb->conectar();
    $No_documento = $_GET["No_documento"];
    $consultasql = "Select * FROM cliente where No_documento='" . $No_documento . "'";
    $resultado = $conexion->prepare($consultasql);
    $resultado->execute();
    if ($resultado) {
        try {
            $eliminar = $conexion->prepare("DELETE FROM cliente WHERE No_documento = ?");
            $registro = $eliminar->execute([$No_documento]);
           
        } catch (PDOException $e) { 
            header("Location: index.php?error=1");
            exit; 
        }
        header("Location: Index.php");
    }

}