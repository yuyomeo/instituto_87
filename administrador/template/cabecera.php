<!DOCTYPE html>
<html lang="es">

<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Location:../index.php");
    } else {
        if ($_SESSION["usuario"]=="ok") {
            $nombreUsuario=$_SESSION["nombreUsuario"];
        }
    }
?>

<?php $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87"; ?>

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
                <a class="nav-link" href="#">Usuarios</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/carreras.php">Carreras</a>
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
                <a class="nav-link" href=<?php echo $url;?>/administrador/cerrar.php>Cerrar Sesión</a>
            </li>
        </ul>
    </nav>

    <br/>

    <div class="container">
        <div class="row">
            
