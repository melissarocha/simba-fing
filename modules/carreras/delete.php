<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_carrera = null;

if ( !empty($_GET['id_carrera']) ) {
    $id_carrera = $_REQUEST['id_carrera'];
}

if ( null == $id_carrera ) {
    header("Location: carreras.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_carrera = $_POST['id_carrera'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM carreras WHERE id_carrera = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_carrera));
    Database::disconnect();
    header("Location: carreras.php");
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
            <h3>Eliminar carrera</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_carrera" value="<?php echo $id_carrera;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar la carrera
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM carreras WHERE id_carrera = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_carrera));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $clave_carrera = $data['clave_carrera'];
                    $nombre_carrera = $data['nombre_carrera'];
                    Database::disconnect();
                    echo $clave_carrera . ' - ' . $nombre_carrera;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="carreras.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>