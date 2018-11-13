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
          <a class="btn btn-primary btn-block" href="../modules/alumnos/alumnos.php" role="button">Alumnos</a>
          <a class="btn btn-primary btn-block" href="../modules/archivo/archivo.php" role="button">Archivo</a>
          <a class="btn btn-primary btn-block" href="../modules/asistencias/asistencias.php" role="button">Asistencias</a>
          <a class="btn btn-primary btn-block" href="../modules/becas/becas.php" role="button">Becas</a>
          <a class="btn btn-primary btn-block" href="../modules/carreras/carreras.php" role="button">Carreras</a>
          <a class="btn btn-primary btn-block" href="../modules/semestres/semestres.php" role="button">Semestres</a>
          <a class="btn btn-primary btn-block" href="../modules/estados/estados.php" role="button">Estados</a>


        </div>
    </div> <!-- /container -->

<?php
include ('../views/footer.php');
?>
