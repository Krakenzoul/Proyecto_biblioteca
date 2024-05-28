<?php
if (!isset($_GET["No_prestamo"])) {
    echo "<div class='alert alert-danger' role='alert'>";
    echo "el numero de Id no se encuentra registrado, ingrese un número valido";
    echo "</div>";
} else {
    include_once "../../Conection/ConectBD.php";
    $objdb = new ConexionBDPDO();
    $conexion = $objdb->conectar();
    $No_prestamo = $_GET["No_prestamo"];
    $consultasql = "SELECT * FROM prestamo WHERE No_prestamo = ?";
    $resultado = $conexion->prepare($consultasql);
    $resultado->execute([$No_prestamo]);
    if ($resultado->rowCount() > 0) {
        $eliminar = $conexion->prepare("UPDATE libro 
        JOIN prestamo AS p ON p.id_libro = libro.id_libro
        JOIN devoluciones AS d ON d.No_prestamo = p.No_prestamo
        SET libro.estado = 1  WHERE p.No_prestamo =?");
        $registro = $eliminar->execute([$No_prestamo]);
        if ($registro) {
            $eliminar = $conexion->prepare("DELETE FROM prestamo WHERE No_prestamo = ?");
            $registro = $eliminar->execute([$No_prestamo]);
            if (!$registro) {
                echo "Error al eliminar el préstamo.";
            }
        } else {
            echo "Error al actualizar el estado del libro.";
        }
    } else {
        echo "No se encontró el préstamo con el número de Id proporcionado.";
    }
    header("Location: Index.php");
}
