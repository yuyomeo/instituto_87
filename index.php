<?php
    if ($_POST) {
        header("Location:administrador");
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
