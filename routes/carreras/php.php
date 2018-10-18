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
        <h2>Carreras</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre de la carrera</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM carreras';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['id_carrera'] . '</td>';
                    echo '<td>'. $row['nombre_carrera'] . '</td>';
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
