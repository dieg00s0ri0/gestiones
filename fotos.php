<?php
$cnx = conexion('implementtaTolucaP');
$sql_fotos = "SELECT a.*,CONVERT(varchar, a.fechaCaptura,1) AS  Fecha,DescripcionTarea FROM registrofotomovil as a inner join CatalogoTareas as b on a.idTarea=b.IdTarea
        WHERE a.cuenta='101-10-188-30-00-0000'";
$cnx_sql_fotos = sqlsrv_query($cnx, $sql_fotos);
$contador = 0;
?>
<div class="row">
    <div class="col-md-8">
        <h6 class="text-shadow"><img src="https://img.icons8.com/fluency/35/camera.png" alt=""> Fotos Registradas</h6>
        <table class="table table-sm" style="text-align: center;">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align:center;">Num.</th>
                    <th style="text-align:center;">Nombre</th>
                    <th style="text-align:center;">fecha Captura</th>
                    <th style="text-align:center;">tipo</th>
                    <th style="text-align:center;">Tarea</th>
                    <th style="text-align:center;">Acción</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($fotos = sqlsrv_fetch_array($cnx_sql_fotos)) { ?>
                    <tr>
                        <td class="table-light"><?php echo $contador += 1 ?></td>
                        <td class="table-light"><?php echo $fotos['nombreFoto'] ?></td>
                        <td class="table-light"><?php echo $fotos['Fecha'] ?></td>
                        <td class="table-light"><?php echo $fotos['tipo'] ?></td>
                        <td class="table-light"><?php echo $fotos['DescripcionTarea'] ?></td>
                        <td class="table-light">
                            <input type="hidden" name="url" id="ur[<?php echo $contador ?>]" value="<?php echo $fotos['urlImagen'] ?>">
                            <button class="btn" type="submit" onclick="view(<?php echo $contador ?>)"><img src="https://img.icons8.com/fluency/20/image.png" /></button>
                            <button class="btn" type="submit"><img src="https://img.icons8.com/fluency/20/delete-trash.png" /></button>
                            <button class="btn" type="button" data-toggle="modal" data-target="#modalfoto" id="btnmodalfoto" title="Actualizar foto" data-id="<?php echo $fotos['idRegistroFoto'] ?>"
                            data-tipo="<?php echo $fotos['tipo'] ?>">
                                <img src="https://img.icons8.com/fluency/20/edit-text-file.png" /></button>

                        </td>
                    </tr>
                <?php }  ?>

            </tbody>
        </table>

    </div>
    <div class=" col-md-4">
        <h6 class="text-shadow"><img src="https://img.icons8.com/fluency/35/visible.png" alt=""> Visualización de Fotos</h6>
        <img id="vistaprevia" style="min-width: 100%; height: 70vh; margin: auto;">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalfoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualización de Fotos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="text" id="idm" name="id">
                    <label for="formFileSm" class="form-label">Foto de tipo <label id="tipom"></label>:*</label>
                    <input class="form-control form-control-sm" name="foto" id="foto" type="file" onchange="return validarExtF()" accept=".png, .img,.jpg,.jpeg" required>
                    <br>
                    <div style="margin-left: 100px;" id="imgpreview" class="styleImage"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>