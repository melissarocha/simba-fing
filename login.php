<?php

  session_start();



  if (isset($_SESSION['user_id'])) {
    header('Location: /ksimba');
  }
  require 'database.php';


  if (!empty($_POST['nombre_usuario']) && !empty($_POST['contrasena'])) {
      $pdo = Database::connect();
    $records = $pdo->prepare('SELECT id_control_acceso, nombre_usuario, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario');
      //$sql = ('SELECT id_control_acceso, nombre_usuario, contrasena FROM usuarios WHERE nombre_usuario = :nombre_usuario');
    $records->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
    //$sql->bindParam(':nombre_usuario', $_POST['nombre_usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && ($_POST['contrasena'] == $results['contrasena'])){
      $_SESSION['contrasena'] = $results['contrasena'];
      $_SESSION['user_id'] = $results['id_control_acceso'];


      if ( $_SESSION['user_id'] == 1 ) {
         header("Location: master/menu_master.php");
        // code...
      }else if ($_SESSION['user_id'] == 2) {
          header("Location: admin/menu_admin.php");

      }else if   ($_SESSION['user_id'] == 3) {
            header("Location: cafeteria/menu_cafeteria.php");
      }else if ($_SESSION['user_id'] == 4) {
            header("Location: invitado/menu_invitado.php");
      }else{

        echo "esto no se deberia imprimir jamas";
      }



    } else {
      $message = 'Datos incorrectos';
    }
  }
  Database::disconnect();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>


    <?php endif; ?>

    <h1>Iniciar sesion</h1>
    <!--<span>o <a href="signup.php">registrarse</a></span>-->

    <form action="login.php" method="POST">
      <input name="nombre_usuario" type="text" placeholder="Introduce tu usuario ">
      <input name="contrasena" type="password" placeholder="introduce tu contraseña">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
