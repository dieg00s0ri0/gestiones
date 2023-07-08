<?php
require "../include/cnx.php";
$bd = $_POST['bd'];
$rol = $_POST['rol'];
$registro = $_POST['registro'];
$cuenta = $_POST['cuenta'];
$tabla = $_POST['tabla'];
$fecha = $_POST['FechaCaptura'];
$IdAspUser = $_POST['IdAspUser'];
$IdTarea = $_POST['IdTarea'];

$fecha_old = $_POST['fecha_old'];
$IdAspUser_old = $_POST['IdAspUser_old'];
$IdTarea_old = $_POST['IdTarea_old'];
// echo $fecha_old;

$cnx = conexion($bd);
//actualizar la gestion
$update_sql = "update $tabla set fechaCaptura=?,IdAspUser=?,idTarea=?";
$update = sqlsrv_query($cnx, $update_sql, array($fecha, $IdAspUser, $IdTarea));
//si si se actualizo
if ($update = sqlsrv_query($cnx, $update_sql, array($fecha, $IdAspUser, $IdTarea))) {
    $update_sql_foto = "update RegistroFotomovilprueba set idAspUser=?,idTarea=?,fechaCaptura=?
    where idRegistroFoto in(
    select f.idRegistroFoto from $tabla a
    inner join [dbo].Registrofotomovilprueba f on a.cuenta=f.cuenta 
    where convert(date,f.fechacaptura)='$fecha_old'
    and a.$idRegistro='$registro' and f.IdAspUser='$IdAspUser_old')";
    // actualizar foto
    $update_sql_foto = "update RegistroFotomovilprueba set idAspUser='$IdAspUser',idTarea='$IdTarea',fechaCaptura='$fecha',fechaSincronizacion='$fecha'
    where convert(date,fechaCaptura)=convert(date,'$fecha_old') and cuenta='$cuenta' and idAspUser='$IdAspUser_old'";
    // echo $update_sql_foto;
    //si se actualiza mandar mensaje
    if ($update_foto = sqlsrv_query($cnx, $update_sql_foto)) {
        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&UpdateGestion");
    } else {
        // en caso contrario regresar la gestion a como estaba para que siga cruzando con la foto y mandar mensaje de error
        $update_sql_gestion = "update $tabla set fechaCaptura=?,IdAspUser=?,idTarea=?";
        if ($update_gestion = sqlsrv_query($cnx, $update_sql_gestion, array($fecha_old, $IdAspUser_old, $IdTarea_old))) {
            header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorUpdateGestion");
        }
    }
} else {
    header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorUpdateGestion");
}
