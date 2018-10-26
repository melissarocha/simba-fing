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
        <h2>Usuarios</h2>
    </div>
    <div class="row">
        <p>
            <a class="btn btn-success" href="new.php">Agregar nuevo usuario</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nombre del usuario</th>
                <th>Correo electrónico</th>
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
                $sql = 'SELECT id_usuario, nombre_usuario, correo_electronico, tipo_usuario FROM usuarios u
                        INNER JOIN control_accesos ca ON u.id_control_acceso = ca.id_control_acceso 
                        ORDER BY id_usuario;';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['nombre_usuario'] . '</td>';
                    echo '<td>'. $row['correo_electronico'] . '</td>';
                    echo '<td>'. $row['tipo_usuario']. '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-primary btn-sm" href="edit.php?id_usuario='.$row['id_usuario'].'">Editar</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id_usuario='.$row['id_usuario'].'">Eliminar</a>';
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