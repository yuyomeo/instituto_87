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

<head>

    <?php $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87" ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Instituto 87 </title>
    <link href="<?php echo $url;?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $url;?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $url;?>/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php echo $url;?>/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="<?php echo $url;?>/js/jquery-3.5.1.js"></script>
    <script src="<?php echo $url;?>/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="<?php echo $url;?>/css/sweetalert2.min.css">
    <script src="<?php echo $url;?>/js/sweetalert2.all.js"></script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/usuarios.php">Usuarios</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/carreras.php">Carreras</a>
            </li>    
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url;?>/administrador/materias.php">Materias</a>
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
            
