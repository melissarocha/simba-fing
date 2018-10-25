<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_control_acceso = null;

if ( !empty($_GET['id_control_acceso']) ) {
    $id_control_acceso = $_REQUEST['id_control_acceso'];
}

if ( null == $id_control_acceso ) {
    header("Location: accesos.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_control_acceso = $_POST['id_control_acceso'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM control_accesos WHERE id_control_acceso = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_control_acceso));
    Database::disconnect();
    header("Location: accesos.php");
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
            <h3>Eliminar control de acceso</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_control_acceso" value="<?php echo $id_control_acceso;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar el control de acceso
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM control_accesos WHERE id_control_acceso = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_control_acceso));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $clave_control_acceso = $data['clave_control_acceso'];
                    $tipo_usuario = $data['tipo_usuario'];
                    Database::disconnect();
                    echo $clave_control_acceso . ' - ' . $tipo_usuario;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="accesos.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>