<?php
include ('../../views/header.php');
?>
<div class="container">
    <div class="row">
        <h2>Becas</h2>
    </div>
    <div class="row">
        <p>
            <a class="btn btn-success" href="new.php" >Agregar nueva Beca</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre de la beca</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <!--Metodo para renderizar los datos de la tabla-->
                <?php
                include '../../config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM becas ORDER BY id_beca';
                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>'. $row['clave_beca'] . '</td>';
                    echo '<td>'. $row['nombre_beca'] . '</td>';
                    echo '<td><a class="btn btn-primary btn-sm" href="edit.php?id='.$row['id'].'">Editar</a></td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
            </tr>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
