<?php

//obtener todos los gestores

//gestores
$sql_gestores = "select a.Id,a.Nombre as Usuario from AspNetUsers as a 
    inner join AspNetUserRoles as b on a.Id=b.UserId
    inner join AspNetRoles as c on b.RoleId=c.Id
    where c.Name in('Gestor') and a.Id not in (?)";
$cnx_sql_gestores = sqlsrv_query($cnx, $sql_gestores, array($IdAspUser));
//abogados
$sql_abogados = "select a.Id,a.Nombre as Usuario from AspNetUsers as a 
    inner join AspNetUserRoles as b on a.Id=b.UserId
    inner join AspNetRoles as c on b.RoleId=c.Id
    where c.Name in('Abogado') and a.Id not in (?)";
$cnx_sql_abogados = sqlsrv_query($cnx, $sql_abogados, array($IdAspUser));
//cortes
$sql_cortes = "select a.Id,a.Nombre as Usuario from AspNetUsers as a 
    inner join AspNetUserRoles as b on a.Id=b.UserId
    inner join AspNetRoles as c on b.RoleId=c.Id
    where c.Name in('Cortes') and a.Id not in (?)";
$cnx_sql_cortes = sqlsrv_query($cnx, $sql_cortes, array($IdAspUser));
if ($rolId != 0) {

    //obtener las tareas
    $sql_tareas = "select a.IdTarea,a.DescripcionTarea from catalogoTareas as a 
        where a.RoleId=? and a.IdTarea not in (?)";
    $cnx_sql_tareas = sqlsrv_query($cnx, $sql_tareas, array($rolId, $datos['IdTarea']));
}



?>
<div class="row">
    <div class=" container col-12">
        <div class="p-3 mx-auto">
            <form action="crud/UpdateGestion.php" method="POST">
                <input type="hidden" name="bd" value="<?php echo $bd ?>">
                <input type="hidden" name="rol" value="<?php echo $rol ?>">
                <input type="hidden" name="tabla" value="<?php echo $tabla ?>">
                <input type="hidden" name="registro" value="<?php echo $registro ?>">
                <input type="hidden" name="cuenta" value="<?php echo $cuenta ?>">
                <input type="hidden" type="datetime-local" name="fecha_old" value="<?php echo $datos['Fecha'] ?>">
                <input type="hidden" name="IdAspUser_old" value="<?php echo $IdAspUser ?>">
                <input type="hidden" name="IdTarea_old" value="<?php echo $datos['IdTarea']  ?>">
             
                <div class="p-2 rounded-4" style=" background-color: #F1F3F3; border: inherit; ">
                    <div class="text-white m-2 align-items-end" style="text-align:right;">
                        <span class="bg-success rounded-2 p-2"><img src="https://img.icons8.com/fluency/30/000000/user-manual.png" />Datos de la gestión</span>
                    </div>
                    <div class="row align-items-start form-row">
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Fecha de captura:*</label>
                                <input type="datetime-local" class="form-control form-control-sm mb-2" name="FechaCaptura" value="<?php echo $datos['Fecha'] ?>" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Usuario quien gestionó:*</label>
                                <select class="custom-select custom-select-sm" name="IdAspUser">
                                    <!-- ------------------------------------------------------------------------------------------ -->
                                    <?php if ($rolSelect == 'Gestor') { ?>
                                        <optgroup label="Gestores">
                                            <option value="<?php echo $datos['IdAspUser'] ?>" selected><?php echo utf8_encode($datos['Nombre']) ?></option>
                                            <?php while ($usuarios1 = sqlsrv_fetch_array($cnx_sql_gestores)) { ?>
                                                <option value="<?php echo $usuarios1['Id'] ?>"><?php echo utf8_encode($usuarios1['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Abogados">

                                            <?php while ($usuarios2 = sqlsrv_fetch_array($cnx_sql_abogados)) { ?>
                                                <option value="<?php echo $usuarios2['Id'] ?>"><?php echo utf8_encode($usuarios2['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Cortes">

                                            <?php while ($usuarios3 = sqlsrv_fetch_array($cnx_sql_cortes)) { ?>
                                                <option value="<?php echo $usuarios3['Id'] ?>"><?php echo utf8_encode($usuarios3['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>
                                    <!-- ------------------------------------------------------------------------------------------------------------------- -->
                                    <?php if ($rolSelect == 'Abogado') { ?>
                                        <optgroup label="Abogado">
                                            <option value="<?php echo $datos['IdAspUser'] ?>" selected><?php echo utf8_encode($datos['Nombre']) ?></option>
                                            <?php while ($usuarios1 = sqlsrv_fetch_array($cnx_sql_abogados)) { ?>
                                                <option value="<?php echo $usuarios1['Id'] ?>"><?php echo utf8_encode($usuarios1['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Gestores">

                                            <?php while ($usuarios2 = sqlsrv_fetch_array($cnx_sql_gestores)) { ?>
                                                <option value="<?php echo $usuarios2['Id'] ?>"><?php echo utf8_encode($usuarios2['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Cortes">

                                            <?php while ($usuarios3 = sqlsrv_fetch_array($cnx_sql_cortes)) { ?>
                                                <option value="<?php echo $usuarios3['Id'] ?>"><?php echo utf8_encode($usuarios3['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>
                                    <!-- ---------------------------------------------------------------------------- -->
                                    <?php if ($rolSelect == 'Cortes') { ?>
                                        <optgroup label="Cortes">
                                            <option value="<?php echo $datos['IdAspUser'] ?>" selected><?php echo utf8_encode($datos['Nombre']) ?></option>
                                            <?php while ($usuarios1 = sqlsrv_fetch_array($cnx_sql_cortes)) { ?>
                                                <option value="<?php echo $usuarios1['Id'] ?>"><?php echo utf8_encode($usuarios1['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Gestores">

                                            <?php while ($usuarios2 = sqlsrv_fetch_array($cnx_sql_gestores)) { ?>
                                                <option value="<?php echo $usuarios2['Id'] ?>"><?php echo utf8_encode($usuarios2['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>

                                        <optgroup label="Abogados">

                                            <?php while ($usuarios3 = sqlsrv_fetch_array($cnx_sql_abogados)) { ?>
                                                <option value="<?php echo $usuarios3['Id'] ?>"><?php echo utf8_encode($usuarios3['Usuario']) ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>
                                    <!-- ------------------------------------------------------------------------------------------------- -->
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Tarea:*</label>
                                <select class="custom-select custom-select-sm" name="IdTarea">
                                    <option value="<?php echo $datos['IdTarea'] ?>" selected><?php echo utf8_encode($datos['DescripcionTarea']) ?></option>
                                    <?php if ($rolId == 0) {
                                    } else {
                                        while ($tareas = sqlsrv_fetch_array($cnx_sql_tareas)) { ?>
                                            <option value="<?php echo $tareas['IdTarea'] ?>"><?php echo utf8_encode($tareas['DescripcionTarea']) ?></option>
                                    <?php }
                                    } ?>
                                </select>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-row p-4">
                    <div class="col">
                        <div style="text-align:right;">
                            <button type="submit" class="btn btn-info btn-sm" target="_blank"><img src="https://img.icons8.com/fluency/30/synchronize.png" />
                                Actualizar Gestión</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>