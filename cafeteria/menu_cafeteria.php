<?php

  session_start();

?>



<?php


include ('../views/header.php');
?>

    <div class="jumbotron">
        <h1 class="display-4">Hola, bienvenido a SIMBA!</h1>
        <p class="lead">SIMBA es un sistema que permite el manejo de becas alimenticias dentro de la Facultad de Ingenieria.</p>
        <hr class="my-4">
        <p>Buscamos siempre mejorar el apoyo a los estudiantes manteniendo en orden el cobro e ingreso de las becas.</p>
        <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> --->
    </div>

    <div class="container">
        <div class="row col">
            <a class="btn btn-primary btn-block" href="../modules/alumnos/alumnos.php" role="button">Cafeteria</a>

        </div>
    </div> <!-- /container -->

<?php
include ('../views/footer.php');
?>
