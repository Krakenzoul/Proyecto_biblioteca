<?php
if (!isset($_GET["No_prestamo"])) {
    exit("No existe el id_libro.....");
} else {
    include_once "../../Conection/ConectBD.php";
    $objdb = new ConexionBDPDO();
    $conexion = $objdb->conectar();
    $no_prestamo = $_GET["No_prestamo"];
    $consultasql = "Select * FROM devoluciones where No_prestamo='" . $no_prestamo . "'";
    $resultado = $conexion->prepare($consultasql);
    $resultado->execute();
    if ($resultado) {
        $eliminar = $conexion->prepare("DELETE FROM devoluciones WHERE No_prestamo = ?");
        $registro = $eliminar->execute([$no_prestamo]);
    }
    header("Location: Index.php");
}