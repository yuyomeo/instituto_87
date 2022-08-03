<?php include("../template/cabecera.php"); ?>

<?php
    $sndNombre=(isset($_POST["fndNombre"]))?$_POST["fndNombre"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtNivel=(isset($_POST["txtNivel"]))?$_POST["txtNivel"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    include("../../config/conexionBD.php");

    switch ($accion) {
        case "Eliminar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
            $sentenciaSQL->bindParam(':nombre', $sndNombre);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $bdNombre=(isset($dato["nombre"]))?$dato["nombre"]:"";
            if ($_POST["fndNombre"]==$bdNombre) {
                $_SESSION['varTemp'] = $sndNombre;
                $txtNombre=$dato['nombre'];
                $txtNivel=$dato['nivel'];
            }
            break;
        case "Borrar":
            if ($_SESSION["nombreUsuario"]!=$txtNombre) {
                $sentenciaSQL=$conexion->prepare("DELETE FROM usuarios WHERE nombre=:nombre");
                $sentenciaSQL->bindParam(':nombre', $txtNombre);
                $sentenciaSQL->execute();
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "success",
                            title: "El usuario ha sido eliminado",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                    setTimeout( function() { window.location.href = "../usuarios.php"; }, 1500 );
                </script>
                ';
            } else {
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "error",
                            title: "¡Para eliminar este usuario debes cerrar la sesión!",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                </script>
                ';
            }
            break;
    }
    
?>

<br>
<div class="card col-md-5 mx-auto">
    <div class="card-header">
        <h3> Datos del usuario a eliminar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12">
                <input type="text" class="form-control" name="sndNombre" value="<?php echo $sndNombre; ?>" id="sndNombre" hidden>
                <form method="POST">
                    <div class="col-md-12">
                        <div class="md-form form-group">
                            <label for="txtNombre">Nombre de usuario</label>
                            <input type="text" class="form-control" pattern="*" maxlength="30" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" readonly>   
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="md-form form-group">
                            <label for="txtNivel">Nivel de acceso</label>
                            <input type="text" class="form-control col-md-12" name="txtNivel" value="<?php echo $txtNivel==1?'Directivo':($txtNivel==2?'Preceptoría':'Alumno') ?>" id="txtTipo" readonly>
                        </div>
                    </div>
                    <br>                            
                    <button type="button" class="btn btn-primary" onclick="location.href='../usuarios.php'">Volver</button>
                    <button type="submit" name="accion" value="Borrar" class="btn btn-primary float-right">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>                             

<?php include("../template/pie.php"); ?>