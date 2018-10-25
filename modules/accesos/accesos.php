<?php
include ('../../views/header.php');
?>
<div class="container">
    <div class="row">
        <h2>Control de accesos</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Tipo de usuario</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM control_accesos';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['clave_control_acceso'] . '</td>';
                    echo '<td>'. $row['tipo_usuario'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
            </tr>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->


