<?php
session_start();

  require 'database.php';
  if (isset($_SESSION['user_id'])) {
      $pdo = Database::connect();
    $records = $pdo->prepare('SELECT id_control_acceso, nombre_usuario, contrasena FROM usuarios WHERE id_usuario = :id_usuario');
    $records->bindParam(':id_control_acceso', $_SESSION['user_id']);
   $pdo->execute();


    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;// code...
    }
  }
    Database::disconnect();
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SIMBA</title>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  <body background="assets/imagenes/2.png" width="10" height="10";>
      <?php require 'partials/header.php' ?>

 <?php if (!empty($user)):




      //  <br>vista de  <?= $user['nombre_usuario']  ?>
      <!--  <br>login exitoso -->

        <a href="logout.php">
logout
        </a>

      <?php else: ?>


          <h1>
        <a href="login.php" style="color:blue" > iniciar sesion</a>
      </h1>
        <!--<a href="signup.php">registrarse</a> -->

      <?php endif; ?>


  </body>
</html>
