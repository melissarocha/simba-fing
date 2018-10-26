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
        <h2>Control de accesos</h2>
    </div>
    <div class="row">
        <p>
            <a class="btn btn-success" href="new.php">Agregar nuevo acceso</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Tipo de usuario</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Método para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM control_accesos ORDER BY id_control_acceso';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['clave_control_acceso'] . '</td>';
                    echo '<td>'. $row['tipo_usuario'] . '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-primary btn-sm" href="edit.php?id_control_acceso='.$row['id_control_acceso'].'">Editar</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id_control_acceso='.$row['id_control_acceso'].'">Eliminar</a>';
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