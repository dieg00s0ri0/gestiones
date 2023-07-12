<?php
require "../include/awsv2/vendor/autoload.php";
require "funcionesS3.php";
require "../include/cnx.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

if (isset($_POST['idDelete']) and isset($_POST['bd']) and isset($_POST['rol']) and isset($_POST['registro']) and isset($_POST['cuenta']) and isset($_POST['nombre'])) {
   
    $bd = $_POST['bd'];
    $rol = $_POST['rol'];
    $registro = $_POST['registro'];
    $cuenta = $_POST['cuenta'];
    $idRegistroFoto = $_POST['idDelete'];
    $nombre = $_POST['nombre'];

    $cnx = conexion($bd);

    $s3 = S3Client::factory([
        'version' => '2006-03-01',
        'region' => 'us-east-1',
        'credentials' => [
            'key' => 'AKIAQAVQA6VN3G4QA5GC',
            'secret' => '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',
        ]
    ]);
    
    $bucket='fotos-implementta-movil';

    $existe=exists($s3,$bucket,$nombre);

    if ($existe==1) {//si existe 
        // lo eliminamos 
        $delete=delete($s3,$bucket,$nombre);
        if ($delete!=0) {//si si se elimino
            
            $delete_sql_foto = "DELETE FROM RegistroFotomovilprueba WHERE idRegistroFoto='$idRegistroFoto'";
            if ($delete_foto = sqlsrv_query($cnx, $delete_sql_foto)) {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&DeleteFoto");
            } else {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorDeleteFoto");
            }
        }else {
            header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
        }
    }elseif ($existe==2) {//si no se encontro el archivo entonces solo lo eliminamos de la bd
        $delete_sql_foto = "DELETE FROM RegistroFotomovilprueba WHERE idRegistroFoto='$idRegistroFoto'";
            if ($delete_foto = sqlsrv_query($cnx, $delete_sql_foto)) {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&DeleteFoto");
            } else {
                header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorDeleteFoto");
            }
    }else{
        header("location:../?bd=$bd&rol=$rol&registro=$registro&cuenta=$cuenta&ErrorS3");
    }

} else {
    echo '<meta http-equiv="refresh" content="0,url=./">';
}

// echo $update_sql_foto;
//si se actualiza mandar mensaje
