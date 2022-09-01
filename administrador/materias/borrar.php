<?php
    include("../../config/conexionBD.php");
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $sentenciaSQL=$conexion->prepare("DELETE FROM materias WHERE codigo=:oldCodigo AND nombre=:oldNombre");
    $sentenciaSQL->bindParam(':oldCodigo', $codigo);
    $sentenciaSQL->bindParam(':oldNombre', $nombre);
    $sentenciaSQL->execute();
?>