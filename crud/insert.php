<?php
require "../include/cnx.php";
require "../include/awsv2/vendor/autoload.php";
require "funcionesS3.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


if (
    isset($_POST['tipo']) and isset($_FILES["Agregarfoto"]["name"]) and isset($_POST['fecha']) and isset($_POST['IdAspUser'])
    and isset($_POST['IdTarea'])
    and isset($_POST['bd']) and isset($_POST['rol']) and isset($_POST['registro']) and isset($_POST['cuenta'])
) {
    $bd = $_POST['bd'];
    $rol = $_POST['rol'];
    $registro = $_POST['registro'];
    $cuenta = $_POST['cuenta'];

    $IdAspUser = $_POST['IdAspUser'];
    $IdTarea = $_POST['IdTarea'];
    $tipo = utf8_encode($_POST['tipo']);
    $file = $_FILES["Agregarfoto"];
    $fecha = $_POST['fecha'];

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fechaHoraActual = date('Y-m-d H:i:s');
    $key = $cuenta . $fechaHoraActual . '.'.$extension;

    $file_path = $file['tmp_name'];

    $bucket = 'fotos-implementta-movil';

    // $file_path="C:\Users\diego\Documents\universidad\\trabajo\gestiiones\\".$file_name;

    $s3 = S3Client::factory([
        'version' => '2006-03-01',
        'region' => 'us-east-1',
        'credentials' => [
            'key' => 'AKIAQAVQA6VN3G4QA5GC',
            'secret' => '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',
        ]
    ]);
    //insertamos el archivo a amazon
    $insert = insert($file_path, $s3, $bucket, $key);
    // validamos si si inserto
    if ($insert == 1) {
        // obtenemos la url
        $signedUrl = url($s3, $key);
        // validamos si nos mando la url
        // echo $signedUrl;
        if ($signedUrl != '') {
            $cnx = conexion($bd);
            // insertamos registro
            $sql_insert = "insert into registrofotomovilprueba (cuenta,idAspUser,nombreFoto,idTarea,fechaCaptura,tipo,urlImagen,Activo,fechaSincronizacion) values
            ('$cuenta','$IdAspUser','$key','$IdTarea','$fecha','$tipo','$signedUrl',1,'$fecha')";
            // echo $sql_actualizar;
            if (sqlsrv_query($cnx, $sql_insert)) {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&InsertFoto");
            } else {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorInsertFoto");
                // echo 'error sql';
            }
        } else {
            header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
            // echo 'error url';
        }
    } else {
        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
        // echo 'error insert';
    }
} else {
    echo '<meta http-equiv="refresh" content="0,url=./">';
}
