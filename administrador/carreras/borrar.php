<?php
    include("../../config/conexionBD.php");
    $resolucion= $_GET['resolucion'];
    $sentenciaSQL=$conexion->prepare("DELETE FROM carreras WHERE resolucion=:oldResolucion");
    $sentenciaSQL->bindParam(':oldResolucion', $resolucion);
    $sentenciaSQL->execute();
?>

