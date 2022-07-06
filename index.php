<?php
    session_start();
    if ($_POST) {
        include("config/conexionBD.php");
        $Usuario=(isset($_POST["usuario"]))?$_POST["usuario"]:"";
        $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios WHERE nombre=:usuario");
        $sentenciaSQL->bindParam(':usuario', $Usuario);
        $sentenciaSQL->execute();
        $dato=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $bdNombre=(isset($dato["nombre"]))?$dato["nombre"]:"";
        $bdClave=(isset($dato["clave"]))?$dato["clave"]:"";
        $bdNivel=(isset($dato["nivel"]))?$dato["nivel"]:"";
        if (($_POST["usuario"]==$bdNombre) && ($_POST["clave"]==$bdClave) && ($bdNivel=="1")) {
            $_SESSION["usuario"]="ok";
            $_SESSION["nombreUsuario"]=$bdNombre;
            header("Location:administrador");
        }
        else {
            $mensaje = "Error: nombre de usuario o contraseña inválido.";
        } 
    }
?>

<?php include("template/cabecera.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            <br/><br/><br/>
                <div class="card">
                    <div class="card-header">
                        Ingreso al sistema:
                    </div>
                    <div class="card-body">
                        <?php if (isset($mensaje)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                        <div class = "form-group">
                        <label for="exampleInputEmail1">Usuario</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Introduzca el nombre de usuario">
                        </div>
                        <br/><br/>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control" name="clave" placeholder="Intruduzca la contraseña">
                        </div>
                        <br/><br/>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

<?php include("template/pie.php"); ?>
