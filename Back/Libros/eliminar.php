<?php
if (!isset($_GET["id_libro"])) {
 exit("No existe el id_libro.....");
}
include_once "../../Conection/ConectBD.php";
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$id_libro = $_GET["id_libro"];
$consultasql="Select * FROM libro where id_libro='".$id_libro."'";
$resultado=$conexion->prepare($consultasql);
$resultado->execute();
if($resultado){
 $eliminar = $conexion->prepare("DELETE FROM libro WHERE id_libro = ?");
 $registro = $eliminar->execute([$id_libro]);
}
header("Location: Index.php");
