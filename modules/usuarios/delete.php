<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_usuario = null;

if ( !empty($_GET['id_usuario']) ) {
    $id_usuario = $_REQUEST['id_usuario'];
}

if ( null == $id_usuario ) {
    header("Location: usuarios.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_usuario = $_POST['id_usuario'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_usuario));
    Database::disconnect();
    header("Location: usuarios.php");
}
?>

<!--Vista-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Eliminar usuario</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar al usuario
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_usuario));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $nombre_usuario = $data['nombre_usuario'];
                    Database::disconnect();
                    echo $nombre_usuario;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="usuarios.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>