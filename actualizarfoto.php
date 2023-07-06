<?php
require "include/cnx.php";
if (isset($_POST['id']) and isset($_POST['tipo']) and isset($_FILES["foto"]["name"])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $foto = $_FILES["foto"]["name"]; //Nombre de nuestro archivo

    $url_temp = $_FILES["foto"]["tmp_name"]; //Ruta temporal a donde se carga el archivo 

    //dirname(__FILE__) nos otorga la ruta absoluta hasta el archivo en ejecución
    $url_insert = dirname(__FILE__) . "/files"; //Carpeta donde subiremos nuestros archivos

    // //Ruta donde se guardara el archivo, usamos str_replace para reemplazar los "\" por "/"
    $url_target = str_replace('\\', '/', $url_insert) . '/' . $foto;
    // unlink($url_target);
    //movemos el archivo de la carpeta temporal a la carpeta objetivo y verificamos si fue exitoso
    if (move_uploaded_file($url_temp, $url_target)) {
        // echo "El archivo " . htmlspecialchars(basename($foto)) . " ha sido cargado con éxito.";
        // subir s3
        // obtener la variable de conexion
        $cnx = conexion('implementtaTolucaP');
        // actualizar registro
            $sql_actualizar = "update registrofotomovilprueba set tipo='$tipo',urlImagen='$url_target' where idRegistroFoto='$id'";
          if(sqlsrv_query($cnx, $sql_actualizar)){
            header('location:./?fotoactualizado');
          }
         
        
        
    } else {
        echo "Ha habido un error al cargar tu archivo.";
    }
} else {
    echo '<meta http-equiv="refresh" content="0,url=./">';
}
