<?php include ("../../Template/header.php");
include_once "../../Conection/ConectBD.php";
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$sql = "SELECT * FROM empleado";
$resultado_em = $conexion->prepare($sql);
$resultado_em->execute();
$empleados = $resultado_em->fetchAll();
$resultado_em->closeCursor();
$no_prestamo = $_GET['No_prestamo'];
?>
<div class=contenesdor-index>
    <div class=div-index1-prestamo>
        <div style='border: 1px solid black; margin: 80px;'>
            <div class='card'>
                <div class='card-header'>Realizar la devolución</div>
                <div class='card-body'>
                    <div class='table-responsive-md'>
                        <form method='post'>
                            <div class="mb-3">
                                <label for="" class="form-label" required>Empleado Encargado</label>
                                <select id="inputState" name="no_empleado" class="form-select" required>
                                    <option selected value="">Seleccionar el empleado encargado</option>
                                    <?php foreach ($empleados as $empleado): ?>
                                        <option value="<?php echo $empleado['No_documento']; ?>">
                                            <?php echo "(" . $empleado['primer_nombre'] . " " . $empleado['primer_apellido']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Descripción de la devolución</label>
                                <input type="text" class="form-control" name="descripcion" id="categoria"
                                    aria-describedby="helpId" placeholder="¿Cómo se ve el libro?" size="20"
                                    minlength="5" required />
                            </div>
                            <div class="form-group"><button class="btn btn-success">Hacer devolución Del Libro</button>
                                <a class="btn btn-info" href="Index.php">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=div-index2-prestamo>
        <img src=../../imagen/buho_logo.jpeg height=300px alt=buho_logo>
    </div>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET["No_prestamo"])) {
        exit("No existe el Prestamo.....");
    } else {
        include_once "../../Conection/ConectBD.php";
        $objdb = new ConexionBDPDO();
        $conexion = $objdb->conectar();
        try {
          
            $consultasql = "CALL traer_datos_prestamo(:no_prestamo)";
            $resultado = $conexion->prepare($consultasql);
            $resultado->execute([':no_prestamo' => $no_prestamo]);
        
            // Obtener los datos del préstamo
            $datos_prestamo = $resultado->fetch(PDO::FETCH_ASSOC);
            $resultado->closeCursor();
            if ($datos_prestamo === false) {
               echo "hola";
            }
            $id_libro = $datos_prestamo['id_libro'];
            if ($id_libro > 0) {
                $no_empleado = $_POST['no_empleado'];
                $tipo = "devolucion";
                $descripcion = $_POST['descripcion'];

                $call_procedure = "call agregar_movimiento('$id_libro','$no_empleado','$tipo','$descripcion')";
                $sentenciasql = $conexion->prepare($call_procedure);
                $sentenciasql->execute();

                // Ejecutar el segundo procedimiento almacenado
                $eliminar = $conexion->prepare("CALL agregar_devolucion(:no_prestamo)");
                $registro = $eliminar->execute([':no_prestamo' => $no_prestamo]);

                header("Location: Index.php");
            } else {
                echo "<div class='alert alert-warning' role='alert'>";
                echo "Hubo un error del número de libro";
                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "<div class='alert alert-warning' role='alert'>";
            echo "Hubo un error, por favor, vuelva a ingresar los datos";
            echo "</div>";
        }

    }
}

?>
<?php include ("../../Template/footer.php") ?>