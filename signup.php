<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['nombre_usuario']) && !empty($_POST['contrasena'])) {
    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (:nombre_usuario, :contrasena)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
      $stmt->bindParam(':contrasena', $_POST['contrasena']);
    //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    //$stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      $message = 'cuenta creada';
    } else {
      $message = 'ocurrio un error';
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Registrate</h1>
    <span>o <a href="login.php">inicia sesion</a></span>

    <form action="signup.php" method="POST">
      <input name="nombre_usuario" type="text" placeholder="nombre">
      <input name="contrasena" type="password" placeholder="contraseña">
      <input name="confirm_password" type="password" placeholder="Confirm contraseña">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>
