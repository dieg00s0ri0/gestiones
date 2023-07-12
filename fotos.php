<?php

$sql_fotos = "select f.*,convert(varchar,f.FechaCaptura,126) AS  Fecha,c.DescripcionTarea from $tabla a
inner join [dbo].Registrofotomovilprueba f on a.cuenta=f.cuenta 
inner join CatalogoTareas as c on f.idTarea=c.IdTarea
where convert(date,a.fechacaptura)=convert(date,f.fechacaptura)
and a.$idRegistro='$registro' and f.IdAspUser='$IdAspUser'";
$cnx_sql_fotos = sqlsrv_query($cnx, $sql_fotos);
$contador = 0;
?>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-shadow"><img src="https://img.icons8.com/fluency/35/camera.png" alt=""> Fotos Registradas</h6>
            </div>
            <div class="col-md-6">
                <button class="btn btn-info float-right" type="button" data-toggle="modal" data-target="#modalfotoAgregar" id="btnmodalfotoAgregar" title="Agregar Registro">
                    <img src="https://img.icons8.com/fluency/28/plus-2-math.png" alt="plus-2-math" /> Agregar</button>
            </div>
        </div>
        <table class="table table-sm" style="text-align: center;">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align:center;">Num.</th>
                    <th style="text-align:center;">fecha Captura</th>
                    <th style="text-align:center;">Nombre</th>
                    <th style="text-align:center;">tipo</th>
                    <th style="text-align:center;">Tarea</th>
                    <th style="text-align:center;">Usuario</th>
                    <th style="text-align:center;">Acción</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($fotos = sqlsrv_fetch_array($cnx_sql_fotos)) { ?>
                    <tr>
                        <td class="table-light"><?php echo $contador += 1 ?></td>
                        <td class="table-light"><?php echo $fotos['Fecha'] ?></td>
                        <td class="table-light"><?php echo $fotos['nombreFoto'] ?></td>
                        <td class="table-light"><?php echo utf8_encode($fotos['tipo']) ?></td>
                        <td class="table-light"><?php echo utf8_encode($fotos['DescripcionTarea']) ?></td>
                        <td class="table-light"><?php echo utf8_encode($datos['Nombre']) ?></td>
                        <td class="table-light">
                            <input type="hidden" name="url" id="ur[<?php echo $contador ?>]" value="<?php echo $fotos['urlImagen'] ?>">
                            <button class="btn" type="submit" onclick="view(<?php echo $contador ?>)" title="Visualizar Foto" ><img src="https://img.icons8.com/fluency/20/image.png" /></button>
                            <button class="btn" type="submit" data-toggle="modal" data-target="#modalfotoDelete" id="btnmodalfotoDelete" title="Eliminar foto" 
                            data-iddelete="<?php echo $fotos['idRegistroFoto'] ?>" data-urldelete="<?php echo $fotos['urlImagen'] ?>"
                            data-nombre="<?php echo $fotos['nombreFoto'] ?>"><img src="https://img.icons8.com/fluency/20/delete-trash.png" /></button>
                            <button class="btn" type="button" data-toggle="modal" data-target="#modalfoto" id="btnmodalfotoupdate" title="Actualizar foto" 
                            data-id="<?php echo $fotos['idRegistroFoto'] ?>" data-tipo="<?php echo utf8_encode($fotos['tipo']) ?>" data-fecha="<?php echo $fotos['Fecha'] ?>"
                            data-nombre="<?php echo $fotos['nombreFoto'] ?>"><img src="https://img.icons8.com/fluency/20/edit-text-file.png" /></button>

                        </td>
                    </tr>
                <?php }  ?>

            </tbody>
        </table>

    </div>
    <div class=" col-md-4">
        <h6 class="text-shadow"><img src="https://img.icons8.com/fluency/35/visible.png" alt=""> Visualización de Fotos</h6>
        <img id="vistaprevia" style="width: 100%; height: 70vh; margin: auto;">
    </div>
</div>

<!-- Modal UPDATE -->
<div id="modalfoto" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="crud/updatefoto.php" method="POST" autocomplete="off" enctype="multipart/form-data">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Actualizacion de fotos</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bd" value="<?php echo $bd ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol ?>">
                    <input type="hidden" name="registro" value="<?php echo $registro ?>">
                    <input type="hidden" name="cuenta" value="<?php echo $cuenta ?>">
                    <input type="hidden" id="idm" name="id">
                    <input type="hidden" id="fecha" name="fecha">
                    <input type="hidden" name="nombre" id="nombreu" >
                    <label for="formFileSm" class="form-label">Foto de tipo:*</label>

                    <select id="comboTipos" name="tipo" class="custom-select custom-select-sm">

                        <option value="" id="labeltipo"></option>
                    </select>

                    <label for="formFileSm" class="form-label">selecciona la foto a remplazar:*</label>
                    <input class="form-control form-control-sm" name="foto" id="foto" type="file" onchange="return validarExtF()" accept=".png, .img,.jpg,.jpeg" required>
                    <br>
                    <div style="margin-left: 100px;" id="imgpreview" class="styleImage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Delete -->
<div id="modalfotoDelete" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="crud/DeleteFoto.php" method="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Eliminacion de Imagén</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="iddelete" name="idDelete">
                    <input type="hidden" name="bd" value="<?php echo $bd ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol ?>">
                    <input type="hidden" name="registro" value="<?php echo $registro ?>">
                    <input type="hidden" name="cuenta" value="<?php echo $cuenta ?>">
                    <input type="hidden" name="nombre" id="nombre" >
                    <label for="formFileSm" class="form-label">Esta Seguro de Eliminar Esta Foto?</label>
                    <img id="fotod" src="" alt="" class="foto_modal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><img src="https://img.icons8.com/fluency/24/cancel.png" alt=""> Cerrar</button>
                    <button type="submit" class="btn btn-warning btn-sm"><img src="https://img.icons8.com/fluency/24/delete-forever.png" alt=""> Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- modal insert -->
<div id="modalfotoAgregar" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="crud/insert.php" method="POST" autocomplete="off" enctype="multipart/form-data">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Registro de Fotos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bd" value="<?php echo $bd ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol ?>">
                    <input type="hidden" name="registro" value="<?php echo $registro ?>">
                    <input type="hidden" name="cuenta" value="<?php echo $cuenta ?>">
                    <input type="hidden" name="fecha" value="<?php echo $datos['Fecha'] ?>">
                    <input type="hidden" name="IdAspUser" value="<?php echo $IdAspUser ?>">
                    <input type="hidden" name="IdTarea" value="<?php echo $datos['IdTarea']  ?>">
                    <label for="formFileSm" class="form-label">Foto de tipo:*</label>

                    <select name="tipo" class="custom-select custom-select-sm" required>
                        <option value="">--Selecciona un tipo--</option>
                        <option value="Evidencia">Evidencia</option>
                        <option value="Predio">Predio</option>
                        <option value="Acta circunstanciada">Acta circunstanciada</option>
                    </select>
                    <label for="formFileSm" class="form-label">selecciona la foto a subir:*</label>
                    <input class="form-control form-control-sm" name="Agregarfoto" id="Agregarfoto" type="file" onchange="return validarExtFAgregar()" accept=".png, .img,.jpg,.jpeg" required>
                    <br>
                    <div style="margin-left: 100px;" id="Agregarimgpreview" class="styleImage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-sm"><img src="https://img.icons8.com/fluency/24/insert.png" alt=""> Insertar</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>