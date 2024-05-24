<?php

if (!isset($_GET["No_prestamo"])) {
    exit("No existe el Prestamo.....");
} else {
    include_once "../../Conection/ConectBD.php";
    $objdb = new ConexionBDPDO();
    $conexion = $objdb->conectar();
    $no_prestamo = $_GET['No_prestamo'];
    $consultasql = "CALL traer_datos_prestamo(:no_prestamo)";
    $resultado = $conexion->prepare($consultasql);
    $resultado->execute([':no_prestamo' => $no_prestamo]);

 
    $resultado->closeCursor();

    // Ejecutar el segundo procedimiento almacenado
    $eliminar = $conexion->prepare("CALL agregar_devolucion(:no_prestamo)");
    $registro = $eliminar->execute([':no_prestamo' => $no_prestamo]);
    header("Location: Index.php");
}