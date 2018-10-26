<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$id_alumno = null;

if ( !empty($_GET['id_alumno']) ) {
    $id_alumno = $_REQUEST['id_alumno'];
}

if ( null == $id_alumno ) {
    header("Location: alumnos.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $id_alumno = $_POST['id_alumno'];

    // Eliminación de los datos
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM alumnos WHERE id_alumno = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id_alumno));
    Database::disconnect();
    header("Location: alumnos.php");
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
            <h3>Eliminar alumno</h3>
        </div>
        <form class="form-horizontal" action="delete.php" method="post">
            <input type="hidden" name="id_alumno" value="<?php echo $id_alumno;?>" />
            <p class="alert alert-error">¿Estás seguro de borrar el alumno
                <b><?php
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM alumnos WHERE id_alumno = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($id_alumno));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    $matricula = $data['matricula'];
                    $nombre_alumno = $data['nombre_alumno'];
                    $apellido_paterno = $data['apellido_paterno'];
                    $apellido_materno = $data['apellido_materno'];
                    Database::disconnect();
                    echo $matricula . ' - ' . $nombre_alumno . ' ' . $apellido_paterno . ' ' . $apellido_materno;
                    ?></b>? Esta acción no se puede deshacer.
            </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a class="btn" href="alumnos.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>