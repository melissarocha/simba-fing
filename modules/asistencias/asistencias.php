<?php

//include '../../views/header.php';
//include '../../views/footer.php';

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
    <div class="row">
        <h2>Asistencias</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Matrícula</th>
                <th>Matrícula</th>
                <th>Fecha de asistencia</th>
                <th>Hora de asistencia</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT id_asistencia_beca, matricula, nombre_alumno, apellido_paterno, apellido_materno, fecha_asistencia_beca, hora_asistencia_beca FROM asistencias_beca ab 
                        INNER JOIN alumnos a ON ab.id_alumno = a.id_alumno
                        ORDER BY id_asistencia_beca;';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['matricula'] . '</td>';
                    echo '<td>'. $row['nombre_alumno'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . '</td>';
                    echo '<td>'. $row['fecha_asistencia_beca'] . '</td>';
                    echo '<td>'. $row['hora_asistencia_beca'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>

</html>