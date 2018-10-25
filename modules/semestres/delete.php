<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_semestre = null;

if ( !empty($_GET['id_semestre']) ) {
    $id_semestre = $_REQUEST['id_semestre'];
}

if ( null == $id_semestre ) {
    header("Location: semestres.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_semestre = $_POST['id_semestre'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM semestres WHERE id_semestre = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_semestre));
    Database::disconnect();
    header("Location: semestres.php");
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
            <h3>Eliminar semestre</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_semestre" value="<?php echo $id_semestre;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar el semestre
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM semestres WHERE id_semestre = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_semestre));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $clave_semestre = $data['clave_semestre'];
                    $nombre_semestre = $data['nombre_semestre'];
                    Database::disconnect();
                    echo $clave_semestre . ' - ' . $nombre_semestre;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="semestres.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>