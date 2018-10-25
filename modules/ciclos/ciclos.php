<?php
include ('../../views/header.php');
?>
<div class="container">
    <div class="row">
        <h2>Ciclos escolares</h2>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre del semestre</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM semestres';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['clave_semestre'] . '</td>';
                    echo '<td>'. $row['nombre_semestre'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
            </tr>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->

