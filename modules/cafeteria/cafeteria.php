<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

if ( !empty($_POST) ) {
    // Definición de variables, capturando la información de los inputs
    $matricula = null;
    $nombre_alumno = null;
    $apellido_paterno = null;
    $apellido_materno = null;
    $nombre_carrera = null;
    $matricula = $_POST['matricula'];

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
//    $stmt = $pdo -> prepare("SELECT matricula, nombre_alumno, apellido_paterno, apellido_materno, nombre_carrera FROM asistencias_beca ab
//                                       INNER JOIN alumnos a ON ab.id_alumno = a.id_alumno
//                                       LEFT JOIN carreras c ON a.id_carrera = c.id_carrera
//                                       WHERE matricula = $");
    $stmt = $pdo -> prepare("SELECT nombre_alumno FROM asistencias_beca ab 
                                       INNER JOIN alumnos a ON ab.id_alumno = a.id_alumno
                                       WHERE matricula = $");
    $stmt -> execute([$matricula]);
    $nombre_alumno = $stmt -> fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    // Contador para encontrar registros duplicados
//    $pdo = Database::connect();
//    $stmt = $pdo -> prepare("SELECT count(*) FROM control_accesos WHERE clave_control_acceso = ?");
//    $stmt -> execute([$clave_control_acceso]);
//    $count = $stmt -> fetchColumn();
//    Database::disconnect();
//
//    // VALIDACIONES
//    // Validaciones de la variable 'clave_control_acceso'
    $valid = true;
//    if ( $count > 0 ) { // En caso de encontrar registro duplicados...
        //$matriculaError = "La clave " . $matriculaError . " ya existe.";
      //  $valid = false;
//    } else
    if ( empty($matricula) ) { // En caso de que el input esté vacío...
        $matriculaError = 'Por favor ingresa la matricula que identificar al alumno.';
        $valid = false;
    } elseif ( strlen($matricula) != 6 ) { // En caso de que 'matricula' no sea de 6 caracteres de longitud...
        $matriculaError = 'La clave de la alumno debe tener 6 caracteres.';
        $valid = false;
    } elseif ( !preg_match('/^[0-9]+$/', $matricula) ) { // En caso de que la 'matricula' no sea numerica...
        $matriculaError = 'La clave debe contener solo números.';
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        echo("<script>console.log('Nombre del alumno: ". $nombre_alumno ."');</script>");

//        $pdo = Database::connect();
//        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $sql = "INSERT INTO control_accesos (clave_control_acceso, tipo_usuario) values(?, ?)";
//        $q = $pdo -> prepare($sql);
//        $q -> execute(array($clave_control_acceso, $tipo_usuario));
//        Database::disconnect();
        //header("Location: ../../index.php");
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
