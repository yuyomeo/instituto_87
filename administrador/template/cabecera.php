<!DOCTYPE html>
<html lang="es">
<head>

    <?php $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87" ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Instituto 87 </title>
    <link rel="stylesheet" href="<?php echo $url;?>/css/bootstrap.min.css" />

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Carrera</a>
            </li>    
            <li class="nav-item">
                <a class="nav-link" href="#">Materias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/alumnos.php">Alumnos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profesores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>">Cerrar Sesión</a>
            </li>
        </ul>
    </nav>

    <br/><br/><br/>

    <div class="container">
        <div class="row">
            
