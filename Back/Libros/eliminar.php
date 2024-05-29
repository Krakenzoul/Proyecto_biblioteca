<?php include ("../../Template/header.php");
include_once "../../Conection/ConectBD.php";
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$sql = "SELECT * FROM empleado";
$resultado_em = $conexion->prepare($sql);
$resultado_em->execute();
$empleados = $resultado_em->fetchAll();
$resultado_em->closeCursor();
?>
<div class=contenesdor-index>
    <div class=div-index1-prestamo>
        <div style='border: 1px solid black; margin: 80px;'>
            <div class='card'>
                <div class='card-header'>Editar información del Libro</div>
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
                                <label for="" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" id="categoria"
                                    aria-describedby="helpId" placeholder="¿Por qué se elimina el libro?" size="15"
                                    minlength="5" required />
                            </div>
                            <div class="form-group"><button class="btn btn-success">Eliminar Libro</button>
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
    if (!isset($_GET["id_libro"])) {
        exit("No existe el id_libro.....");
    } else {
        try {
            $id_libro = $_GET["id_libro"];
            $sql = "UPDATE movimientos_libro SET id_libro = NULL WHERE id_libro = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_libro]);
            $stmt->closeCursor();

            $no_empleado = $_POST['no_empleado'];
            $tipo="eliminacion";
            $descripcion = $_POST['descripcion'];
            $call_procedure = "call agregar_movimiento($id_libro,'$no_empleado','$tipo','$descripcion')";
            $sentenciasql = $conexion->prepare($call_procedure);
            $sentenciasql->execute();
    
            $consultasql = "Select * FROM libro where id_libro='" . $id_libro . "'";
            $resultado = $conexion->prepare($consultasql);
            $resultado->execute();
            if ($resultado) {
                $eliminar = $conexion->prepare("DELETE FROM libro WHERE id_libro = ?");
                $registro = $eliminar->execute([$id_libro]);
            }
        } catch (PDOException $e) {

            echo "<div class='alert alert-warning' role='alert'>";
            echo "Hubo un error, por favor, vuelva a ingresar los datos: " . $e->getMessage();
            echo "</div>";
        }
       
    }
    header("Location: Index.php");
}

?>
<?php include ("../../Template/footer.php") ?>