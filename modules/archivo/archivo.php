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
        <h2>Archivo</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nombre del alumno</th>
                <th>Beca asignada</th>
                <th>Semestre</th>
                <th>Dias asignados</th>
                <th>Dias gastados en el semestre</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT id_archivo_alumno, matricula, nombre_alumno, apellido_paterno, apellido_materno, nombre_beca, nombre_semestre, dias_asignados, dias_gastados_semestre FROM archivo_alumno aa 
                        INNER JOIN alumnos a ON aa.id_alumno = a.id_alumno 
                        INNER JOIN becas b ON aa.id_beca = b.id_beca 
                        INNER JOIN semestres s ON aa.id_semestre = s.id_semestre
                        ORDER BY id_archivo_alumno;';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['matricula'] . '</td>';
                    echo '<td>'. $row['nombre_alumno'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . '</td>';
                    echo '<td>'. $row['nombre_beca'] . '</td>';
                    echo '<td>'. $row['nombre_semestre'] . '</td>';
                    echo '<td>'. $row['dias_asignados'] . '</td>';
                    echo '<td>'. $row['dias_gastados_semestre'] . '</td>';
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