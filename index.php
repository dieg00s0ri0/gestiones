<?php
$bd=$_GET['bd'];
$rol=$_GET['rol'];
$registro=$_GET['registro'];
$cuenta=$_GET['cuenta'];
require "include/cnx.php";
$cnx = conexion($bd);
//obtengo el id del rol

$sql_IdRol= "select a.Id from AspNetRoles as a where a.Name='$rol'";
$cnx_sql_IdRol = sqlsrv_query($cnx, $sql_IdRol);
$IdRol = sqlsrv_fetch_array($cnx_sql_IdRol);
$rolId=$IdRol['Id'];



$tabla='';
$idRegistro='';
//validamos que tabla se ocupara
if($rol=='Gestor'){
  $tabla='RegistroGestorprueba';
  $idRegistro='IdRegistroGestor';
}
if($rol=='Abogado'){
  $tabla='RegistroAbogadoprueba';
  $idRegistro='IdRegistroAbogado';
}
if($rol=='Cortes'){
  $tabla='RegistroReductoresprueba';
  $idRegistro='IdRegistroReductores';
}
if($rol=='Carta'){
  $tabla='RegistroCartaInvitacionprueba';
  $idRegistro='IdRegistroCartaInvitacion';
}
//consulta datos de la gestion
$sql_datos= "SELECT convert(varchar,a.FechaCaptura,21) AS  Fecha,a.IdTarea,DescripcionTarea,a.IdAspUser,c.Nombre FROM $tabla as a inner join CatalogoTareas as b on a.IdTarea=b.IdTarea
inner join AspNetUsers as c on a.IdAspUser=c.id
WHERE a.$idRegistro='$registro'";
$cnx_sql_datos = sqlsrv_query($cnx, $sql_datos);
$datos = sqlsrv_fetch_array($cnx_sql_datos);
$IdAspUser=$datos['IdAspUser'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestiones</title>
  <link rel="icon" href="public/img/implementtaIcon.png">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="public/fontawesome/css/all.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" id="theme-styles">
  <script src="sweetalert/alertas.js"></script>
  <!--<script src="../js/ajaxDeter.js"></script>-->

  <style>
    body {
      background-image: url(public/img/back.jpg);
      background-repeat: repeat;
      background-size: 100%;
      background-attachment: fixed;
      overflow-x: hidden;
      /* ocultar scrolBar horizontal*/
    }

    body {
      font-family: sans-serif;
      font-style: normal;
      font-weight: normal;
      width: 100%;
      height: 100%;
      margin-top: -1%;
      margin-bottom: 0%;
      padding-top: 0px;
      
    }
    table,td,tr{
      font-size: 10px;
    }

    .contenedor {
      margin: auto;
      width: 90%;
    }

    ul li a {
      color: #0d0d0d !important;
    }

    ul li a:hover {
      background-color: #0d0d0d !important;
      border-color: #0d0d0d !important;
      color: white !important;
      /* transform: translateY(-10px); */
    }
    .texto{
      font-size: 18px !important;
    }
  </style>
  
  <?php require "include/nav.php"; ?>
  <!--*************************************NAVBAR*************************************************************-->
</head>

<body>
<?php if (isset($_GET['fotoactualizado'])) { ?>
    <script>
      compilado('Datos Actualizados Correctamente')
    </script>;
  <?php } ?>
  <hr>
  <div class="contenedor">

    <div class="my-2">
      <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="48" height="48" src="https://img.icons8.com/fluency/48/edit-text-file.png" alt="edit-text-file" /> Registro de Gestiones manual</h4>
    </div>
    <div class="row" style="text-align: center;">
      <div class="col-md-4">
        <h6 style="text-shadow: 0px 0px 2px #717171;"><img " src=" https://img.icons8.com/fluency/24/database.png" /> Plaza: <?php echo $bd ?></h6>
      </div>
      <div class="col-md-4">
        <h6 style="text-shadow: 0px 0px 2px #717171;"><img src="https://img.icons8.com/fluency/24/businessman.png" alt=""> Rol: <?php echo $rol ?></h6>
      </div>
      <div class="col-md-4">
        <h6 style="text-shadow: 0px 0px 2px #717171;"><img src="https://img.icons8.com/fluency/24/gender-neutral-user.png" alt=""> Cuenta: <?php echo $cuenta ?></h6>
      </div>
    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="datos" aria-selected="true">Gestión</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " id="fotos-tab" data-toggle="tab" href="#fotos" role="tab" aria-controls="fotos" aria-selected="false">Fotos</a>
      </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
      <?php require "datos_gestor.php"; ?>
      </div>
      <div class="tab-pane " id="fotos" role="tabpanel" aria-labelledby="fotos-tab">
        <?php require "fotos.php"; ?>
      </div>

    </div>




  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
<hr>
<?php require "include/footer.php"; ?>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<script src="scripts/preview_foto.js"></script>
<script src="scripts/modalFoto.js"></script>
<script src="scripts/validarExtF_preview.js"></script>
<!-- <script src="scripts/modalpreviewfoto.js"></script> -->



</html>