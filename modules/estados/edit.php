<?php

// include ('../../views/header.php');
// include ('../../views/footer.php');

require '../../config/database.php';

$id_estado = null;

if ( !empty($_GET['id_estado']) ) {
    $id_estado = $_REQUEST['id_estado'];
}

if ( null == $id_estado ) {
    header("Location: estados.php");
}

if ( !empty($_POST) ) {
    // Definición de variable para capturar el dato de 'clave_estado' directamente desde la base de datos
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM estados where id_estado = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_estado));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $clave_estado_compara = $data['clave_estado'];
    Database::disconnect();

    // Definición de variables, capturando la información de los inputs
    $clave_estado = null;
    $nombre_estado = null;
    $clave_estado = $_POST['clave_estado'];
    $nombre_estado = $_POST['nombre_estado'];

    // Transforma a mayúsculas la variable 'clave_estado'
    $clave_estado = strtoupper($clave_estado);

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM estados WHERE clave_estado = ?");
    $stmt -> execute([$clave_estado]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_estado'
    $valid = true;
    if ( ($count > 0) && ($clave_estado_compara != $clave_estado) ) { // En caso de encontrar registro duplicados y permitir la sobreescritura del registro...
        $claveError = "La clave " . $clave_estado . " ya existe.";
        $valid = false;
    } else if ( empty($clave_estado) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para id_estadoentificar la estado.';
        $valid = false;
    } elseif ( strlen($clave_estado) != 2 ) {  // En caso de que 'clave_estado' no sea de 2 caracteres de longitud...
        $claveError = 'La clave de la estado debe tener 2 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $clave_estado)) === false ) {
        $claveError = 'La clave debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'nombre_estado'
    if ( empty($nombre_estado) ) {  // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre de la estado.';
        $valid = false;
    } elseif ( strlen($nombre_estado) > 30 ) { // En caso de que 'clave_estado' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $nombre_estado)) === false ) {
        $nombreError = 'El nombre debe contener solo letras.';
        $valid = false;
    }

    // Actualización de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE estados SET clave_estado = ?, nombre_estado = ? WHERE id_estado = ?;";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_estado, $nombre_estado, $id_estado));
        Database::disconnect();
        header("Location: estados.php");
    }
} else {
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM estados where id_estado = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_estado));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $nombre_estado = $data['nombre_estado'];
    $clave_estado = $data['clave_estado'];
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
            <h3>Actualizar estado</h3>
        </div>
        <form class="form-horizontal" action="edit.php?id_estado=<?php echo $id_estado?>" method="post">
            <div class="control-group <?php echo !empty($claveError)?'error':'';?>">
                <label class="control-label">Clave del estado</label>
                <div class="controls">
                    <input name="clave_estado" type="text" placeholder="Clave del estado" value="<?php echo !empty($clave_estado)?$clave_estado:'';?>">
                    <?php if (!empty($claveError)): ?>
                        <span class="help-inline"><?php echo $claveError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
                <label class="control-label">Nombre del estado</label>
                <div class="controls">
                    <input name="nombre_estado" type="text" placeholder="Nombre del estado" value="<?php echo !empty($nombre_estado)?$nombre_estado:'';?>">
                    <?php if (!empty($nombreError)): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn" href="estados.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
