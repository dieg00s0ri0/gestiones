<?php
if (isset($_POST['tabla']) and isset($_POST['FechaCaptura']) and isset($_POST['IdAspUser']) and isset($_POST['IdTarea']) and isset($_POST['fecha_old'])
    and isset($_POST['IdAspUser_old']) and isset($_POST['IdTarea_old'])
    and isset($_POST['bd']) and isset($_POST['rol']) and isset($_POST['registro']) and isset($_POST['cuenta'])) {
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

//si si se actualizo
if ($update = sqlsrv_query($cnx, $update_sql, array($fecha, $IdAspUser, $IdTarea))) {
    
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
} else {
    echo '<meta http-equiv="refresh" content="0,url=./">';
}
