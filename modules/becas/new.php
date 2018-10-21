<?php

require '../../config/database.php';

if ( !empty($_POST)) {
    // Valida si los campos estan vacios
    $clave_beca = null;
    $nombre_beca = null;

    // Captura los valores de entrada del formulario
    $clave_beca = $_POST['clave_beca'];
    $nombre_beca = $_POST['nombre_beca'];

    // VALIDACIONES
    // Validaciones del clave_beca
    $valid = true;
    if (empty($clave_beca)) {
        $claveError = 'Por favor ingresa la clave para identificar la beca.';
        $valid = false;
    } elseif (strlen($clave_beca) != 2) {
        $claveError = 'La clave de la beca debe tener 2 caracteres.';
        $valid = false;
    }

    // Validaciones del nombre_beca
    if (empty($nombre_beca)) {
        $nombreError = 'Por favor ingresa el nombre de la beca.';
        $valid = false;
    } elseif (strlen($nombre_beca) > 30) {
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    }

    // Hace mayusculas clave_beca para guardar mejor el dato
    $clave_beca = strtoupper($clave_beca);

    // INSTERTA LOS DATOS A LA BD
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO becas (clave_beca,nombre_beca) values(?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($clave_beca,$nombre_beca));
        Database::disconnect();
        header("Location: becas.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">

        <div class="span10 offset1">
            <div class="row">
                <h3>Agregar nuevo Alumno</h3>
            </div>

            <form class="form-horizontal" action="new.php" method="post">
                <div class="control-group <?php echo !empty($claveError)?'error':'';?>">
                    <label class="control-label">Clave de la beca</label>
                    <div class="controls">
                        <input name="clave_beca" type="text"  placeholder="Clave de la beca" value="<?php echo !empty($clave_beca)?$clave_beca:'';?>">
                        <?php if (!empty($claveError)): ?>
                            <span class="help-inline"><?php echo $claveError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
                    <label class="control-label">Nombre de la beca</label>
                    <div class="controls">
                        <input name="nombre_beca" type="text" placeholder="Nombre de la beca" value="<?php echo !empty($nombre_beca)?$nombre_beca:'';?>">
                        <?php if (!empty($nombreError)): ?>
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

    </div> <!-- /container -->
</body>
</html>