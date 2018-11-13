<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <h2>Usuarios</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Tipo de usuario</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM usuarios';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['nombre_usuario'] . '</td>';
                    echo '<td>'. $row['id_control_acceso'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
            </tr>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
</body>
</html>
