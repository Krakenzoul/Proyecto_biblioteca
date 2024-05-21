<?php
$db = new ConexionBDPDO();
$conexion = $db->conectar();
$no_prestamo = $_GET['No_prestamo'];
$consultasql = "call traer_datos_prestamo($no_prestamo)";
$resultado = $conexion->prepare($consultasql);
$resultado->execute();
$o = $resultado->fetch();
if ($resultado) {
    $editar = $conexion->prepare("UPDATE prestamo set estado =0 WHERE No_prestamo = ?");
    $registro = $editar->execute([$no_prestamo]);
    $editar = $conexion->prepare("UPDATE libro set estado =1 WHERE id_libro = ?");
    $registro = $editar->execute($o['id_libro']);
    $editar = $conexion->prepare(" call agregar_devolucion($no_prestamo)");
    $registro = $editar->execute([$no_prestamo]);
}