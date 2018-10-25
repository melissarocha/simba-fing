<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_estado = null;

if ( !empty($_GET['id_estado']) ) {
    $id_estado = $_REQUEST['id_estado'];
}

if ( null == $id_estado ) {
    header("Location: estados.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_estado = $_POST['id_estado'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM estados WHERE id_estado = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_estado));
    Database::disconnect();
    header("Location: estados.php");
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
            <h3>Eliminar estado</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_estado" value="<?php echo $id_estado;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar el estado
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM estados WHERE id_estado = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_estado));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $clave_estado = $data['clave_estado'];
                    $nombre_estado = $data['nombre_estado'];
                    Database::disconnect();
                    echo $clave_estado . ' - ' . $nombre_estado;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="estados.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>