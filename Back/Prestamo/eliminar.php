<?php
if (!isset($_GET["No_prestamo"])) {
    echo "<div class='alert alert-danger' role='alert'>";
    echo "el numero de Id no se encuentra registrado, ingrese un número valido";
    echo "</div>";
}
include_once "../../Conection/ConectBD.php";
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$No_prestamo = $_GET["No_prestamo"];
$consultasql="Select * FROM prestamo where No_prestamo='".$No_prestamo."'";
$resultado=$conexion->prepare($consultasql);
$resultado->execute();
if($resultado){
 $eliminar = $conexion->prepare("DELETE FROM prestamo WHERE No_prestamo = ?");
 $registro = $eliminar->execute([$No_prestamo]);
}
header("Location: Index.php");
