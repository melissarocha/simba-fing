<?php
include ('../../views/header.php');
?>
<div class="container">
    <div class="row">
        <h2>Archivo</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Matrícula</th>
                <th>Semestre</th>
                <th>Beca asignada</th>
                <th>Dias asignados</th>
                <th>Dias gastados</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM archivo_alumno';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['matricula'] . '</td>';
                    echo '<td>'. $row['clave_semestre'] . '</td>';
                    echo '<td>'. $row['clave_beca'] . '</td>';
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
</div> <!-- /container -->
