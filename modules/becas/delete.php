<?php

include '../../views/header.php';
include '../../views/footer.php';

require '../../config/database.php';

$id_beca = null;

if ( !empty($_GET['id_beca']) ) {
    $id_beca = $_REQUEST['id_beca'];
}

if ( null == $id_beca ) {
    header("Location: becas.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_beca = $_POST['id_beca'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM becas WHERE id_beca = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_beca));
    Database::disconnect();
    header("Location: becas.php");
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
            <h3>Eliminar beca</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_beca" value="<?php echo $id_beca;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar la beca
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM becas WHERE id_beca = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_beca));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $clave_beca = $data['clave_beca'];
                    $nombre_beca = $data['nombre_beca'];
                    Database::disconnect();
                    echo $clave_beca . ' - ' . $nombre_beca;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="becas.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>