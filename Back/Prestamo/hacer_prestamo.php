<?php
include "../../Template/header.php";
include ("../../Conection/ConectBD.php");
include "prestamo.php";
date_default_timezone_set("America/Mexico_City");

$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$prestamo = new Prestamo();
$informacion_libro = 0;
$informacion_persona = 0;
$id_libro = 0;
$nombre_columna = "";
$verificar = 0;
$prestamo->setFecha(date("Y-m-d", time()));
// Calcular la fecha 15 días después
$prestamo->setFecha_devolucion(
    date("Y-m-d", strtotime($prestamo->getFecha() . " + 15 days"))
);
$fecha = $prestamo->getFecha();
$fecha_devolucion = $prestamo->getFecha_devolucion();

$sql = "SELECT * FROM empleado";
$resultado_em = $conexion->prepare($sql);
$resultado_em->execute();
$empleados = $resultado_em->fetchAll();
$resultado_em->closeCursor();

$sql = "SELECT * FROM cliente";
$resultado_cli = $conexion->prepare($sql);
$resultado_cli->execute();
$clientes = $resultado_cli->fetchAll();
$resultado_cli->closeCursor();
?>
<div>
    <div class="container text-center">
        <h1>Información Del Prestamo</h1>
        <div class="row align-items-start">
            <div class="col">
                <div class='card'>
                    <div class='card-header'>
                        <h4>Información Del libro</h4>
                    </div>
                    <div class='card-body'>
                        <div class='table-responsive-md'>

                            <form method='post'>
                                <div class="mb-3">
                                    <label for="" class="form-label">Id del libro</label>
                                    <input type="text" class="form-control" name="id_libro" id="id_libro"
                                        aria-describedby="helpId" placeholder="Numero de identificación del Libro"
                                        required />
                                    <br> <button class="btn btn-success" name="boton_buscar_libro">Buscar Informacion
                                        Libro</button>
                                </div>
                            </form>
                            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                session_start();
                                //Esto hará la busqueda de los datos del libro solo con el id, verificara si existe o no el libro
                                if (isset($_POST["boton_buscar_libro"])) {
                                    $prestamo->setId_libro($_POST["id_libro"]);
                                    $id_libro = $prestamo->getId_libro();
                                    $_SESSION["libro"] = $id_libro;
                                    $sentenciasql = "call nombre_libro($id_libro)";
                                    $resultado = $conexion->prepare($sentenciasql);
                                    $resultado->execute();
                                    $informacion_libro = $resultado->fetch();
                                    $verificar = 1;
                                    if (!$informacion_libro) {
                                        echo "<div class='alert alert-danger' role='alert'>";
                                        echo "el numero de Id no se encuentra registrado, ingrese un número valido";
                                        echo "</div>";
                                    }
                                    $resultado->closeCursor();
                                }
                            } ?>

                            <div class="mb-3">
                                <?php echo "Este es el Id del libro digitado: " .
                                    $prestamo->getId_libro() .
                                    "<br>"; ?>
                                <label for="" class="form-label">Nombre Del Autor</label>
                                <input type="text" value="<?php
                                $nombre_columna = "nombre_autor";
                                mostrar_datos($informacion_libro, $nombre_columna);
                                ?>" class="form-control" name="nombre_autor" id="nombre_autor"
                                    aria-describedby="helpId" placeholder="Nombre Del Autor" <?php estado_input(
                                        $informacion_libro
                                    ); ?> />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Titulo Del libro</label>
                                <input type="text" value="<?php
                                $nombre_columna = "nombre_libro";
                                mostrar_datos($informacion_libro, $nombre_columna);
                                ?>" class="form-control" name="nombre_libro" id="nombre_libro"
                                    aria-describedby="helpId" placeholder="Titulo Del libro" <?php estado_input(
                                        $informacion_libro
                                    ); ?> />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Categoria</label>
                                <input type="text" value="<?php
                                $nombre_columna = "categoria";
                                mostrar_datos($informacion_libro, $nombre_columna);
                                ?>" class="form-control" name="categoria" id="categoria" aria-describedby="helpId"
                                    placeholder="Categoria" <?php estado_input(
                                        $informacion_libro
                                    ); ?> />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Número estanteria</label>
                                <input type="number" value="<?php
                                $nombre_columna = "No_estanteria";
                                mostrar_datos($informacion_libro, $nombre_columna);
                                ?>" class="form-control" name="no_estanteria" id="no_estanteria"
                                    aria-describedby="helpId" placeholder="Número estanteria" <?php estado_input(
                                        $informacion_libro
                                    ); ?> />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Estado</label>
                                <input type="text" value="<?php if (!$informacion_libro) {
                                } else {
                                    if ($informacion_libro["estado"] == 1) {
                                        echo "Disponible";
                                    } else {
                                        $verificar = 0;
                                        echo "En prestamo";
                                    }
                                } ?>" class="form-control" name="no_estanteria" id="no_estanteria"
                                    aria-describedby="helpId" placeholder="Estado" <?php estado_input(
                                        $informacion_libro
                                    ); ?> />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class='card'>
                    <div class='card-header'>
                        <h4>Información Del Ciente</h4>
                    </div>
                    <div class='card-body'>
                        <div class='table-responsive-md'>
                            <form method="POST">

                                <div class="mb-3">
                                    <label for="" class="form-label" required>Número De Documento</label>
                                    <select id="inputState" name="no_cliente" class="form-select" required>
                                        <option selected value="">Seleccione el empleado</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?php echo $cliente['No_documento']; ?>">
                                                <?php echo $cliente['No_documento'] . " " . "(" . $cliente['primer_nombre'] . " " . $cliente['primer_apellido'] . ")"; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label" required>Empleado Encargado</label>
                                    <select id="inputState" name="no_empleado" class="form-select" required>
                                        <option selected value="">Seleccione el empleado</option>
                                        <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?php echo $empleado['No_documento']; ?>">
                                                <?php echo "(" . $empleado['primer_nombre'] . " " . $empleado['primer_apellido']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">

                            <button class="btn btn-success" name="generar_prestamo" <?php if (
                                $verificar === 0
                            ) {
                                echo "disabled";
                            } else {
                                echo "enable";
                            } ?>>Generar Prestamo</button>
                            <a class="btn btn-info" href="Index.php">Volver</a>
                        </div>
                        </form>
                    </div>

                    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST["generar_prestamo"])) {
                            try {
                                $prestamo->setCedula($_POST["no_cliente"]);
                                $no_documento = $prestamo->getCedula();
                                $id_libro = $_SESSION["libro"];
                                $sentenciassql = "call agregar_prestamo('$id_libro','$no_documento','$fecha','$fecha_devolucion')";
                                $resultado = $conexion->prepare($sentenciassql);
                                $resultado->execute();
                                $resultado->closeCursor();

                                $no_empleado = $_POST['no_empleado'];
                                $tipo = "prestamo";
                                $descripcion = "realización de prestamo";

                                $call_procedure = "call agregar_movimiento('$id_libro','$no_empleado','$tipo','$descripcion')";
                                $sentenciasql = $conexion->prepare($call_procedure);
                                $sentenciasql->execute();
                               
                            } catch (PDOException $e) {
                                echo "<div class='alert alert-warning' role='alert'>";
                                echo "Hubo un error, por favor, vuelva a ingresar los datos: " . $e->getMessage();
                                echo "</div>";
                            }

                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>

    </html>

    <?php
    include "../../Template/footer.php";
    function estado_input($informacion_libro)
    {
        if (!$informacion_libro) {
            echo "enable";
        } else {
            echo "disabled";
        }
    }
    function mostrar_datos($informacion_libro, $info)
    {
        if (!$informacion_libro) {
        } else {
            echo $informacion_libro["$info"];
        }
    }

    ?>