<?php include("template/cabecera.php"); ?>

<?php
    include("../config/conexionBD.php");
    $sentenciaSQL=$conexion->prepare("SELECT * FROM carreras");
    $sentenciaSQL->execute(); 
    $listaCarreras=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    $fndResolucion=(isset($_POST["fndResolucion"]))?$_POST["fndResolucion"]:"";
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";
?>

<form action="" method="POST">
    <div class="row">
        <div class="col-10">
            <table class="table table-striped table-bordered" style="width: 100%" id="tabla">
                <thead>
                    <th>Resolución</th>
                    <th>Código</th>
                    <th>Nombre</th>
                </thead>
                <tbody>
                    <?php foreach($listaCarreras as $carrera) { ?>
                    <tr>    
                        <td><?php echo $carrera['resolucion']; ?></td>
                        <td><?php echo $carrera['codigo']; ?></td>
                        <td><?php echo $carrera['nombre']; ?></td>
                    </tr>
                    <?php } ?>     
                </tbody>
            </table>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="fndResolucion"></label>
                <input type="text" class="form-control" name="fndResolucion" id="fndResolucion" hidden>
            </div>
            <div class="btn-toolbar">
                <button type="submit" class="btn btn-primary btn-block mt-3 mb-3" style="width: 100%" name="accion" value="Editar" id="Editar" formaction="materias/editar.php" disabled>Editar materias</button>
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
                "width": "70%", "targets": 2,
            }], 
            "pageLength": 8,
            "lengthChange": false,   
        });
        $('#tabla tbody').on('click', 'tr', function () {
            var pikResolucion = table.row( this ).data()[0];       
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                document.getElementById("fndResolucion").value = "";
                document.getElementById("Editar").disabled = true;
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                document.getElementById("fndResolucion").value = pikResolucion;
                document.getElementById("Editar").disabled = false;
            }
        });
        $('#button').click(function () {
            table.row('.selected').remove().draw(false);
            console.log( table.row( this ).data() );
        });       
    });
</script>

<?php include("template/pie.php"); ?>