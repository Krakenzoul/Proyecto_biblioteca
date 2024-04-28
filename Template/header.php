<?php 
$url_base="http://localhost:3000";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Biblioteca</title>
</head>

<body>
  <div>
    <ul>
      <li><a href="<?php echo $url_base;?>/index.php">Inicio</a></li>
      <li><a href="<?php echo $url_base;?>/Back/Libros/">Libros</a></li>
      <li><a href="<?php echo $url_base;?>/Back/Buscar Libro/">Busqueda de Libros</a></li>
      <li><a href="<?php echo $url_base;?>/Back/Prestamo">Prestamos</a></li>

    </ul>
    
  </div>