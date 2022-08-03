<?php include("template/cabecera.php"); ?>

<?php
    include("../config/conexionBD.php");
    $sentenciaSQL=$conexion->prepare("SELECT * FROM usuarios");
    $sentenciaSQL->execute(); 
    $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    $fndNombre=(isset($_POST["fndNombre"]))?$_POST["fndNombre"]:"";
    $fndNivel=(isset($_POST["fndNivel"]))?$_POST["fndNivel"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";
?>

<form action="" method="POST">
    <div class="row">
        <div class="col-10">
            <table class="table table-striped table-bordered" style="width: 100%" id="tabla">
                <thead>
                    <th>Nombre de usuario</th>
                    <th>Nivel de acceso</th>
                </thead>
                <tbody>
                    <?php foreach($listaUsuarios as $usuario) { ?>
                    <tr <?php echo $usuario['nivel']==0?'style="display: none;"':''; ?> >
                        <td><?php echo $usuario['nombre']; ?></td>           
                        <td><?php echo $usuario['nivel']==1?'Directivo':($usuario['nivel']==2?'Preceptoría':'Alumno'); ?></td>
                    </tr>
                    <?php } ?>     
                </tbody>
            </table>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="fndNombre"></label>
                <input type="text" class="form-control" name="fndNombre" id="fndNombre" hidden>
            </div>
            <div class="btn-toolbar">
                <button type="button" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" onclick="location.href='usuarios/agregar.php'">Agregar nuevo usuario</button> 
                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Modificar" id="Modificar" formaction="usuarios/modificar.php">Modificar mi cuenta</button>
                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Eliminar" id="Eliminar" formaction="usuarios/eliminar.php" disabled>Eliminar otro usuario</button>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo $url;?>/js/jquery-3.5.1.js"></script>
<script src="<?php echo $url;?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $url;?>/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $url;?>/js/popper.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#tabla').DataTable({
            "language": {
                "url": "<?php echo $url;?>/json/spanish.json"
            },
            "columnDefs": [{  
                "width": "50%", "targets": 1,
            }], 
            "pageLength": 8,
            "lengthChange": false,   
        });
        $('#tabla tbody').on('click', 'tr', function () {
            var pikResolucion = table.row( this ).data()[0];       
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                document.getElementById("fndNombre").value = "";
                document.getElementById("Eliminar").disabled = true;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                document.getElementById("fndNombre").value = pikResolucion;
                document.getElementById("Eliminar").disabled = false;
            }
        });
        $('#button').click(function () {
            table.row('.selected').remove().draw(false);
            console.log( table.row( this ).data() );
        });       
    });
</script>

<?php include("template/pie.php"); ?>