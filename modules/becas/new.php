<?php

include '../../views/header.php';
include '../../views/footer.php';

require '../../config/database.php';

if ( !empty($_POST) ) {
    // Definición de variables, capturando la información de los inputs
    $clave_beca = null;
    $nombre_beca = null;
    $clave_beca = $_POST['clave_beca'];
    $nombre_beca = $_POST['nombre_beca'];

    // Transforma a mayúsculas la variable 'clave_beca'
    $clave_beca = strtoupper($clave_beca);

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM becas WHERE clave_beca = ?");
    $stmt -> execute([$clave_beca]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_beca'
    $valid = true;
    if ( $count > 0 ) { // En caso de encontrar registro duplicados...
        $claveError = "La clave " . $clave_beca . " ya existe.";
        $valid = false;
    } else if ( empty($clave_beca) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para identificar la beca.';
        $valid = false;
    } elseif ( strlen($clave_beca) != 2 ) { // En caso de que 'clave_beca' no sea de 2 caracteres de longitud...
        $claveError = 'La clave de la beca debe tener 2 caracteres.';
        $valid = false;
    }

    // Validaciones de la variable 'nombre_beca'
    if ( empty($nombre_beca) ) { // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre de la beca.';
        $valid = false;
    } elseif ( strlen($nombre_beca) > 30 ) { // En caso de que 'clave_beca' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO becas (clave_beca, nombre_beca) values(?, ?)";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_beca, $nombre_beca));
        Database::disconnect();
        header("Location: becas.php");
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
            <h3>Agregar nueva beca</h3>
        </div>
        <form class="form-horizontal" action="new.php" method="post">
            <div class="control-group <?php echo !empty( $claveError )?'error':'';?>">
                <label class="control-label">Clave de la beca</label>
                <div class="controls">
                    <input name="clave_beca" type="text" placeholder="Clave de la beca" value="<?php echo !empty( $clave_beca )?$clave_beca:'';?>">
                    <?php if ( !empty($claveError) ): ?>
                        <span class="help-inline"><?php echo $claveError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty( $nombreError )?'error':'';?>">
                <label class="control-label">Nombre de la beca</label>
                <div class="controls">
                    <input name="nombre_beca" type="text" placeholder="Nombre de la beca" value="<?php echo !empty( $nombre_beca )?$nombre_beca:'';?>">
                    <?php if ( !empty($nombreError) ): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Agregar</button>
                <a class="btn" href="becas.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
