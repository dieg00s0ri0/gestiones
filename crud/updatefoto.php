<?php
require "../include/cnx.php";
require "../include/awsv2/vendor/autoload.php";
require "funcionesS3.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


if (
    isset($_POST['id']) and isset($_POST['tipo']) and isset($_FILES["foto"]["name"]) and isset($_POST['fecha']) and isset($_POST['nombre'])
    and isset($_POST['bd']) and isset($_POST['rol']) and isset($_POST['registro']) and isset($_POST['cuenta'])
) {
    $bd = $_POST['bd'];
    $rol = $_POST['rol'];
    $registro = $_POST['registro'];
    $cuenta = $_POST['cuenta'];

    $id = $_POST['id'];
    $tipo = utf8_encode($_POST['tipo']);
    $file = $_FILES["foto"];
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fechaHoraActual = date('Y-m-d H:i:s');
    $key = $cuenta . $fechaHoraActual . '.' . $extension;
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
    $existe = exists($s3, $bucket, $nombre); //validar si el archivo que pertenece a este registro

    if ($existe == 1) { //si existe 
        // lo eliminamos 
        $delete = delete($s3, $bucket, $nombre);
        if ($delete != 0) { //si si se elimino

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
                    // actualizar registro
                    $sql_actualizar = "update registrofotomovilprueba set urlImagen='$signedUrl',tipo='$tipo',nombreFoto='$key' 
                where idRegistroFoto='$id'";
                    // echo $sql_actualizar;
                    if (sqlsrv_query($cnx, $sql_actualizar)) {
                        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&UpdateFoto");
                    } else {
                        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorUpdateFoto");
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
            header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
        }
    } elseif ($existe == 2) { //si no se encontro el archivo entonces solo subimos la foto y actualizamos en la bd
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
                // actualizar registro
                $sql_actualizar = "update registrofotomovilprueba set urlImagen='$signedUrl',tipo='$tipo',nombreFoto='$key' 
                where idRegistroFoto='$id'";
                // echo $sql_actualizar;
                if (sqlsrv_query($cnx, $sql_actualizar)) {
                    header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&UpdateFoto");
                } else {
                    header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorUpdateFoto");
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
        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
    }
} else {
    echo '<meta http-equiv="refresh" content="0,url=./">';
}
