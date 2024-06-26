<?php
include ("../../Template/header.php");
include ("../../Conection/ConectBD.php");
$objdb = new ConexionBDPDO();
$conexion = $objdb->conectar();
$No_documento = $_GET["No_documento"];
if ($No_documento > 0)
    $sentenciasql = ("call traer_datos_cliente($No_documento)");
$resultado = $conexion->prepare($sentenciasql);
$resultado->execute();
$informacion_persona = $resultado->fetch();
$resultado->closeCursor();
if (!$informacion_persona) {
    exit("el libro no existe.........");
}

?>


<div class=contenedor-index>
    <div class=div-index1-prestamo>
        <div style='border: 1px solid black; margin: 80px;'>
            <div class='card'>
                <div class='card-header'>Editar información Del cliente</div>
                <div class='card-body'>
                    <div class='table-responsive-md'>
                        <form method='POST'>

                            <div class="mb-3">
                                <label for="" class="form-label">Primer Nombre</label>
                                <input type="text" value="<?php echo $informacion_persona["primer_nombre"] ?>"
                                    class="form-control" name="primer_nombre" id="primer_nombre"
                                    aria-describedby="helpId" placeholder="Primer Nombre" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Segundo Nombre</label>
                                <input type="text" value="<?php echo $informacion_persona["segundo_nombre"] ?>"
                                    class="form-control" name="segundo_nombre" id="segundo_nombre"
                                    aria-describedby="helpId" placeholder="Segundo Nombre" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Primer Apellido</label>
                                <input type="text" value="<?php echo $informacion_persona["primer_apellido"] ?>"
                                    class="form-control" name="primer_apellido" id="primer_Apellido"
                                    aria-describedby="helpId" placeholder="Primer Apellido" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Segundo Apellido</label>
                                <input type="text" value="<?php echo $informacion_persona["segundo_apellido"] ?>"
                                    class="form-control" name="segundo_apellido" id="segundo_Apellido"
                                    aria-describedby="helpId" placeholder="Segundo Apellido" required />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Telefono</label>
                                <input type="number" value="<?php echo $informacion_persona["telefono"] ?>"
                                    class="form-control" name="telefono" id="telefono" aria-describedby="helpId"
                                    placeholder="telefono" required />
                            </div>
                            <div class="form-group"><button class="btn btn-success">Guardar Registro</button>
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
include ("cliente.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nueva_persona = new Cliente();
    $conect = $objdb->conectar();
    include ("../verificacion.php");
    try {

        $nueva_persona->setPrimer_nombre($_POST['primer_nombre']);
        $nueva_persona->setSegundo_nombre($_POST['segundo_nombre']);
        $nueva_persona->setPrimer_apellido($_POST['primer_apellido']);
        $nueva_persona->setSegundo_apellido($_POST['segundo_apellido']);
        $nueva_persona->setTelefono($_POST['telefono']);

        $telefono = $nueva_persona->getTelefono();
        $primer_n = $nueva_persona->getPrimer_nombre();
        $segundo_n = $nueva_persona->getSegundo_nombre();
        $prime_a = $nueva_persona->getPrimer_apellido();
        $segundo_a = $nueva_persona->getSegundo_apellido();
        $campos = array($primer_n, $prime_a, $segundo_n, $segundo_a);
        $errores = array();
        foreach ($campos as $campo) {
            if (verifica_valores_especiales($campo) || verifica_valores_numeros($campo)) {
                $errores[] = "El campo contiene caracteres no válidos: " . $campo;
            }

        }

        if (!empty($errores)) {
            echo "<div class='alert alert-warning' role='alert'>";
            echo "Se encontraron errores en los siguientes campos:<br>";
            foreach ($errores as $error) {
                echo "- " . $error . "<br>";
            }
            echo "</div>";
        } else {

            if (contar_numeros($No_documento, 5, 11)) {
                if (contar_numeros($telefono, 10, 11)) {
                    $sentenciasql = $conect->prepare("UPDATE cliente set No_documento=?,primer_nombre=?,segundo_nombre=?,primer_apellido=?,segundo_apellido=?,telefono=? where No_documento=?");
                    $modificar_registro = $sentenciasql->execute([$No_documento, $primer_n, $segundo_n, $prime_a, $segundo_a, $telefono, $No_documento]);
                    header("Location: Index.php");
                } else {
                    echo "<div class='alert alert-warning' role='alert'>";
                    echo "El numero de caracteres minimo para el Número de telefono es 10 y maximo 10";
                    echo "</div>";
                }

            } else {
                echo "<div class='alert alert-warning' role='alert'>";
                echo "El numero de caracteres minimo para el Número de documento es 5 y maximo 10";
                echo "</div>";
            }
        }

    } catch (PDOException $e) {

        echo "<div class='alert alert-warning' role='alert'>";
        echo "Hubo un error, por favor, vuelva a ingresar los datos";
        echo "</div>";
    }

}

?>

<?php include ("../../Template/footer.php");



?>