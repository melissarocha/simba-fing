<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

$matricula = null;

if ( !empty($_GET['matricula']) ) {
    $matricula = $_REQUEST['matricula'];
}

if ( null == $matricula ) {
    header("Location: cafeteria.php");
}

if ( !empty($_POST) ) {
    // Definición de la variable
    $matricula = $_POST['matricula'];

    // Creacion del registro
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO asistencias_beca (id_alumno, fecha_asistencia_beca, hora_asistencia_beca) values(
              (SELECT id_alumno FROM alumnos WHERE matricula = ?), CURDATE(), NOW())";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($matricula));
    Database::disconnect();
    header("Location: cafeteria.php");
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
            <h3>Cobrar beca</h3>
        </div>
        <form class="form-horizontal" action="confirm_matricula.php" method="post">
            <input type="hidden" name="matricula" value="<?php echo $matricula;?>" />
            <div class="alert alert-warning">
                <?php
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT matricula, nombre_alumno, apellido_paterno, apellido_materno, nombre_carrera FROM asistencias_beca ab
                        INNER JOIN alumnos a ON ab.id_alumno = a.id_alumno
                        LEFT JOIN carreras c ON a.id_carrera = c.id_carrera
                        WHERE matricula = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($matricula));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $nombre_alumno = $data['nombre_alumno'];
                $apellido_paterno = $data['apellido_paterno'];
                $apellido_materno = $data['apellido_materno'];
                $nombre_carrera = $data['nombre_carrera'];
                Database::disconnect();
                echo '<h3>Revise los datos antes de efectuar el cobro:</h3>';
                echo '<b>Matricula:</b> ' . $matricula . '<br>';
                echo '<b>Alumno:</b> ' . $nombre_alumno . ' ' . $apellido_paterno . ' ' . $apellido_materno . '<br>';
                echo '<b>Carrera:</b> ' . $nombre_carrera;
                ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Cobrar</button>
                <a class="btn" href="../../cafeteria/menu_cafeteria.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>