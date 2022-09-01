<?php include("../template/cabecera.php"); ?>

<?php
    include("../../config/conexionBD.php");
    
    $fndNombre=(isset($_POST["fndNombre"]))?$_POST["fndNombre"]:"";
    $oldNombre=(isset($_POST["oldNombre"]))?$_POST["oldNombre"]:"";
    $txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
    $txtClave1=(isset($_POST["txtClave1"]))?$_POST["txtClave1"]:"";
    $txtClave2=(isset($_POST["txtClave2"]))?$_POST["txtClave2"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    switch ($accion) {
        case "Modificar1":
            $oldNombre=(isset($fndNombre))?$fndNombre:"";
            $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
            $sentenciaSQL->bindParam(':nombre', $oldNombre);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre=$dato['nombre'];
        break;
        case "Modificar2":
            $oldNombre=(isset($_SESSION["nombreUsuario"]))?$_SESSION["nombreUsuario"]:"";
            $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
            $sentenciaSQL->bindParam(':nombre', $oldNombre);
            $sentenciaSQL->execute();
            $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre=$dato['nombre'];
        break;
        case "Guardar":
            if (($txtNombre=="") || ($txtClave1=="") || ($txtClave2=="")) {
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "error",
                            title: "Faltan datos...",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                </script>
                ';
            } else if ($txtClave1!=$txtClave2) {
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "error",
                            title: "Las contraseñas no coinciden...",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                </script>
                ';    
            } else {
                $sentenciaSQL=$conexion->prepare("UPDATE usuarios SET nombre=:nombre, clave=:clave WHERE nombre=:oldUsuario");
                $sentenciaSQL->bindParam(':nombre', $txtNombre);
                $salt = uniqid(mt_rand(), true);
                $hashClave = password_hash($txtClave1, PASSWORD_DEFAULT);
                $sentenciaSQL->bindParam(':clave', $hashClave);
                $sentenciaSQL->bindParam(':oldUsuario', $oldNombre);
                $sentenciaSQL->execute();
                $_SESSION['nombreUsuario'] = $txtNombre;
                echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            position: "center",
                            type: "success",
                            title: "Los datos fueron guardados",
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                    setTimeout( function() { window.location.href = "../usuarios.php"; }, 1500 );
                </script>
                ';
            }
        break;
    }
?>

<br>
<div class="card col-md-5 mx-auto">
    <div class="card-header">
        <h3> Datos del usuario a modificar </h3>
    </div>
    <div class="card-body">
        <div class="row" justif-content-center>
            <div class="col-md-12"> 
                <form method="POST">
                    <input type="text" class="form-control" name="oldNombre" value="<?php echo $oldNombre; ?>" id="oldNombre" hidden>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtNombre">Nombre de usuario</label>
                                <input type="text" class="form-control" pattern="*" maxlength="30" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" readonly>   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave1">Nueva contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave1" value="" id="txtClave1">   
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <label for="txtClave2">Repetir contraseña</label>
                                <input type="password" class="form-control" pattern="*" maxlength="30" name="txtClave2" value="" id="txtClave2">   
                            </div>
                        </div>
                    </div>
                    <br>                            
                    <button type="button" class="btn btn-primary" onclick="location.href='../usuarios.php'">Volver</button>
                    <button type="submit" name="accion" value="Guardar" class="btn btn-primary float-right">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>                             

<?php include("../template/pie.php"); ?>