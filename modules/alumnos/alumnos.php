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
        <h2>Alumnos</h2>
    </div>
    <div class="row">
        <p>
            <a class="btn btn-success" href="new.php">Agregar nuevo alumno</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre del alumno</th>
                <th>Correo electrónico</th>
                <th>Beca asignada</th>
                <th>Carrera</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Método para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT id_alumno, matricula, nombre_alumno, apellido_paterno, apellido_materno, correo_electronico, nombre_beca, nombre_carrera, nombre_estado FROM alumnos a 
                        INNER JOIN becas b ON a.id_beca = b.id_beca 
                        INNER JOIN carreras c ON a.id_carrera = c.id_carrera 
                        INNER JOIN estados e ON a.id_estado = e.id_estado 
                        ORDER BY id_alumno;';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['matricula'] . '</td>';
                    echo '<td>'. $row['nombre_alumno'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . '</td>';
                    echo '<td>'. $row['correo_electronico'] . '</td>';
                    echo '<td>'. $row['nombre_beca']. '</td>';
                    echo '<td>'. $row['nombre_carrera'] . '</td>';
                    echo '<td>'. $row['nombre_estado'] . '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-primary btn-sm" href="edit.php?id_alumno='.$row['id_alumno'].'">Editar</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id_alumno='.$row['id_alumno'].'">Eliminar</a>';
                    echo '</td>';
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