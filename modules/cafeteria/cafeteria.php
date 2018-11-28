<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

if ( !empty($_POST) ) {
    // Definición de variables, capturando la información de los inputs
    $matricula = null;
    $matricula = $_POST['matricula'];

    // Contador para encontrar registros cobrados en el dia actual y para buscar si existe la matricula en el sistema
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT matricula FROM asistencias_beca ab
                                       INNER JOIN alumnos a ON ab.id_alumno = a.id_alumno
                                       WHERE matricula = ?
                                       AND DATE(NOW()) = DATE(fecha_asistencia_beca)");
    $stmt -> execute([$matricula]);
    $countCobro = $stmt -> fetchColumn();
    $stmt = $pdo -> prepare("SELECT matricula FROM alumnos
                                       WHERE matricula = ?");
    $stmt -> execute([$matricula]);
    $countMatricula = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_control_acceso'
    $valid = true;
    if ( empty($matricula) ) { // En caso de que el input esté vacío...
        $matriculaError = 'Por favor ingresa la matricula que identificar al alumno.';
        $valid = false;
    } elseif ( strlen($matricula) != 6 ) { // En caso de que 'matricula' no sea de 6 caracteres de longitud...
        $matriculaError = 'La clave de la alumno debe tener 6 caracteres.';
        $valid = false;
    } elseif ( !preg_match('/^[0-9]+$/', $matricula) ) { // En caso de que la 'matricula' no sea numerica...
        $matriculaError = 'La clave debe contener solo números.';
        $valid = false;
    } else if ( $countMatricula == 0 ) { // En caso de no encontrar la matrií...
        $matriculaError = "La matricula " . $matricula . " no esta registrada en el programa de becas. Revise la matricula e intente nuevamente.";
        $valid = false;
    } else if ( $countCobro > 0 ) { // En caso de encontrar registro cobrados en el dia actual...
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

        $matriculaError = "La matricula  " . $matricula . " ya cobró la beca del día de hoy " . $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1] . " a las _ inserte variable que imprima la hora aqui parfavar:'v _.";
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        header("Location: ../becas/becas.php"); // No jala
    }
}
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
    <div class="span10 offset1">
        <div class="row">
            <h3>Cobro de becas</h3>
        </div>
        <form class="form-horizontal" action="cafeteria.php" method="post">
            <div class="control-group <?php echo !empty( $matriculaError )?'error':'';?>">
                <label class="control-label">Matricula</label>
                <div class="controls">
                    <input name="matricula" type="text" placeholder="Matricula" value="<?php echo !empty( $matricula )?$matricula:'';?>">
                    <?php if ( !empty($matriculaError) ): ?>
                        <span class="help-inline"><?php echo $matriculaError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>
    </div>
</div>
</body>

</html>
