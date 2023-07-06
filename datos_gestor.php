<?php 

//obtener todos los gestores
$sql_gestores= "select a.Id,a.Nombre from AspNetUsers as a 
inner join AspNetUserRoles as b on a.Id=b.UserId
inner join AspNetRoles as c on b.RoleId=c.Id
where c.Id =? and a.Id not in (?)";
$cnx_sql_gestores = sqlsrv_query($cnx, $sql_gestores,array($rolId,$datos['IdAspUser']));
//obtener las tareas
$sql_tareas= "select a.IdTarea,a.DescripcionTarea from catalogoTareas as a 
where a.RoleId=? and a.IdTarea not in (?)";
$cnx_sql_tareas = sqlsrv_query($cnx, $sql_tareas,array($rolId,$datos['IdTarea']));

?>
<div class="row">
    <div class=" container col-12">
        <div class="p-3 mx-auto">
            <form action="">
                <div class="p-2 rounded-4" style=" background-color: #F1F3F3; border: inherit; ">
                    <div class="text-white m-2 align-items-end" style="text-align:right;">
                        <span class="bg-success rounded-2 p-2"><img src="https://img.icons8.com/fluency/30/000000/user-manual.png" />Datos de la gestión</span>
                    </div>
                    <div class="row align-items-start form-row">
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Fecha de captura:*</label>
                                <input type="datetime-local" class="form-control form-control-sm mb-2" name="FechaCaptura" value="<?php echo $datos['Fecha']?>" required>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Gestor:*</label>
                                <select class="custom-select custom-select-sm"  name="gestor">
                                    <option value="<?php echo $datos['IdAspUser']?>" selected><?php echo $datos['Nombre']?></option>
                                    <?php while($gestores = sqlsrv_fetch_array($cnx_sql_gestores)){ ?>
                                    <option value="<?php echo $gestores['Id']?>"><?php echo utf8_encode($gestores['Nombre'])?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-form form-group">
                                <label for="clavec" class="form-label">Tarea:*</label>
                                <select class="custom-select custom-select-sm" name="tarea">
                                    <option value="<?php echo $datos['IdTarea']?>" selected><?php echo $datos['DescripcionTarea'] ?></option>
                                    <?php while($tareas = sqlsrv_fetch_array($cnx_sql_tareas)){ ?>
                                    <option value="<?php echo $tareas['IdTarea']?>"><?php echo utf8_encode($tareas['DescripcionTarea'])?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-row p-4">
                        <div class="col">
                            <div style="text-align:right;">
                                <button type="submit" class="btn btn-info btn-sm" target="_blank"><img
                                        src="https://img.icons8.com/fluency/30/synchronize.png" />
                                    Actualizar Gestión</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>