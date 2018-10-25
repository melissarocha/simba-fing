<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

if ( !empty($_POST) ) {
    // Definición de variables, capturando la información de los inputs
    $clave_carrera = null;
    $nombre_carrera = null;
    $clave_carrera = $_POST['clave_carrera'];
    $nombre_carrera = $_POST['nombre_carrera'];

    // Transforma a mayúsculas la variable 'clave_carrera'
    $clave_carrera = strtoupper($clave_carrera);

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM carreras WHERE clave_carrera = ?");
    $stmt -> execute([$clave_carrera]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_carrera'
    $valid = true;
    if ( $count > 0 ) { // En caso de encontrar registro duplicados...
        $claveError = "La clave " . $clave_carrera . " ya existe.";
        $valid = false;
    } else if ( empty($clave_carrera) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para identificar la carrera.';
        $valid = false;
    } elseif ( strlen($clave_carrera) > 2 ) { // En caso de que 'clave_carrera' no sea de 2 caracteres de longitud...
        $claveError = 'La clave de la carrera debe tener 2 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $clave_carrera)) === false ) {
        $claveError = 'La clave debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'nombre_carrera'
    if ( empty($nombre_carrera) ) { // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre de la carrera.';
        $valid = false;
    } elseif ( strlen($nombre_carrera) > 30 ) { // En caso de que 'clave_carrera' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( preg_match('/^[a-Z .]+$/', $nombre_carrera) ) {
        $nombreError = 'El nombre debe contener solo letras y/ puntos.';
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO carreras (clave_carrera, nombre_carrera) values(?, ?)";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_carrera, $nombre_carrera));
        Database::disconnect();
        header("Location: carreras.php");
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
            <h3>Agregar nueva carrera</h3>
        </div>
        <form class="form-horizontal" action="new.php" method="post">
            <div class="control-group <?php echo !empty( $claveError )?'error':'';?>">
                <label class="control-label">Clave de la carrera</label>
                <div class="controls">
                    <input name="clave_carrera" type="text" placeholder="Clave de la carrera" value="<?php echo !empty( $clave_carrera )?$clave_carrera:'';?>">
                    <?php if ( !empty($claveError) ): ?>
                        <span class="help-inline"><?php echo $claveError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty( $nombreError )?'error':'';?>">
                <label class="control-label">Nombre de la carrera</label>
                <div class="controls">
                    <input name="nombre_carrera" type="text" placeholder="Nombre de la carrera" value="<?php echo !empty( $nombre_carrera )?$nombre_carrera:'';?>">
                    <?php if ( !empty($nombreError) ): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Agregar</button>
                <a class="btn" href="carreras.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
