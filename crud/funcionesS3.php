<?php
require "../include/awsv2/vendor/autoload.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

function exists($s3,$bucket,$key){
    try {
        // Verificar si el archivo existe en el bucket
        $result_exists = $s3->headObject([
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        // El archivo existe en el bucket entonces lo eliminamos
        // retornamos 1
        return 1;
    } catch (S3Exception $e) {
        if ($e->getAwsErrorCode() == 'NoSuchKey') {
            // El archivo no existe en el bucket retornamos 2
    return 2;
        } else {
            // Otro error ocurrió al verificar la existencia del archivo
            // echo "Ha ocurrido un error al verificar la existencia del archivo: " . $e->getMessage();
            return 0;
        }
    }
}

function insert($file_path,$s3,$bucket,$key){
    try {
        $archivoSubir = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $file_path
        ]);
        return 1;
        //catch de insertar
    } catch (S3Exception $e) {
        // echo $e->getMessage() . "\n";
        return 0;
    }
}
function url($s3,$file_name){
    try{
        $command = $s3->getCommand('GetObject', array(
            'Bucket' => 'fotos-implementta-movil',
            'Key' => $file_name,
        ));
        $signedUrl = $command->createPresignedUrl('+6 years');
        return $signedUrl;
    }catch(S3Exception $e){
        $signedUrl='';
        return $signedUrl;
    }
}

function delete($s3,$bucket,$key){
    try {
        // Eliminar el archivo del bucket
        $result_delete = $s3->deleteObject([
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        // si existe retornamos 1
        return 1;
    } catch (S3Exception $e) {
    //    return "Ha ocurrido un error al eliminar el archivo: " . $e->getMessage();
        // en caso de errror retornat 0
        return 0;
    }
}
?>