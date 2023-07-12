<?php
require "../include/awsv2/vendor/autoload.php";

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
// echo date('TH:i:s');


require "funcionesS3.php";

$s3 = S3Client::factory([
    'version' => '2006-03-01',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => 'AKIAQAVQA6VN3G4QA5GC',
        'secret' => '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',
    ]
]);
$bucket='fotos-implementta-movil';
$key='20407142023-07-12 01:07:55.000Z';

$existe=exists($s3,$bucket,$key);
// $url=url($s3,$key);
// $delete=delete($s3,$bucket,$key);
echo $existe;
?>