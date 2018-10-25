<?php

include '../../views/header.php';
include '../../views/footer.php';

require '../../config/database.php';

$id_beca = null;

if ( !empty($_GET['id_beca']) ) {
    $id_beca = $_REQUEST['id_beca'];
}

if ( null == $id_beca ) {
    header("Location: becas.php");
}

if ( !empty($_POST) ) {
    // Definición de variable para capturar el dato de 'clave_beca' directamente desde la base de datos
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM becas where id_beca = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_beca));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $clave_beca_compara = $data['clave_beca'];
    Database::disconnect();

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
    $valid_beca = true;
    if ( ($count > 0) && ($clave_beca_compara != $clave_beca) ) { // En caso de encontrar registro duplicados y permitir la sobreescritura del registro...
        $claveError = "La clave " . $clave_beca . " ya existe.";
        $valid_beca = false;
    } else if ( empty($clave_beca) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para id_becaentificar la beca.';
        $valid_beca = false;
    } elseif ( strlen($clave_beca) != 2 ) {  // En caso de que 'clave_beca' no sea de 2 caracteres de longitud...
        $claveError = 'La clave de la beca debe tener 2 caracteres.';
        $valid_beca = false;
    }

    // Validaciones de la variable 'nombre_beca'
    if ( empty($nombre_beca) ) {  // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre de la beca.';
        $valid_beca = false;
    }
    elseif ( strlen($nombre_beca) > 30 ) { // En caso de que 'clave_beca' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid_beca = false;
    }

    // Actualización de los datos
    if ( $valid_beca ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE becas SET clave_beca = ?, nombre_beca = ? WHERE id_beca = ?;";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_beca, $nombre_beca, $id_beca));
        Database::disconnect();
        header("Location: becas.php");
    }
} else {
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM becas where id_beca = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_beca));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $nombre_beca = $data['nombre_beca'];
    $clave_beca = $data['clave_beca'];
    Database::disconnect();
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
            <h3>Actualizar beca</h3>
        </div>
        <form class="form-horizontal" action="edit.php?id_beca=<?php echo $id_beca?>" method="post">
            <div class="control-group <?php echo !empty($claveError)?'error':'';?>">
                <label class="control-label">Clave de la beca</label>
                <div class="controls">
                    <input name="clave_beca" type="text" placeholder="Clave de la beca" value="<?php echo !empty($clave_beca)?$clave_beca:'';?>">
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
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn" href="becas.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
