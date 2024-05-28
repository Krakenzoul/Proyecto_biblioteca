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
        $eliminar = $conexion->prepare("DELETE FROM cliente WHERE No_documento = ?");
        $registro = $eliminar->execute([$No_documento]);
        header("Location: Index.php");
    }
    header("Location: Index.php");
}