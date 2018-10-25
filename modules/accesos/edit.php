<?php

// include ('../../views/header.php');
// include ('../../views/footer.php');

require '../../config/database.php';

$id_control_acceso = null;

if ( !empty($_GET['id_control_acceso']) ) {
    $id_control_acceso = $_REQUEST['id_control_acceso'];
}

if ( null == $id_control_acceso ) {
    header("Location: control_accesos.php");
}

if ( !empty($_POST) ) {
    // Definición de variable para capturar el dato de 'clave_control_acceso' directamente desde la base de datos
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM control_accesos where id_control_acceso = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_control_acceso));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $clave_control_acceso_compara = $data['clave_control_acceso'];
    Database::disconnect();

    // Definición de variables, capturando la información de los inputs
    $clave_control_acceso = null;
    $tipo_usuario = null;
    $clave_control_acceso = $_POST['clave_control_acceso'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Transforma a mayúsculas la variable 'clave_control_acceso'
    $clave_control_acceso = strtoupper($clave_control_acceso);

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM control_accesos WHERE clave_control_acceso = ?");
    $stmt -> execute([$clave_control_acceso]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_control_acceso'
    $valid = true;
    if ( $count > 0  && ($clave_control_acceso_compara != $clave_control_acceso) ) { // En caso de encontrar registro duplicados...
        $claveError = "La clave " . $clave_control_acceso . " ya existe.";
        $valid = false;
    } else if ( empty($clave_control_acceso) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para identificar la beca.';
        $valid = false;
    } elseif ( strlen($clave_control_acceso) != 5 ) { // En caso de que 'clave_control_acceso' no sea de 2 caracteres de longitud...
        $claveError = 'La clave de la beca debe tener 5 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $clave_control_acceso)) === false ) {
        $claveError = 'La clave debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'tipo_usuario'
    if ( empty($tipo_usuario) ) { // En caso de que el input esté vacío...
        $tipoError = 'Por favor ingresa el nombre de la beca.';
        $valid = false;
    } elseif ( strlen($tipo_usuario) > 30 ) { // En caso de que 'clave_control_acceso' sea mayor de 30 caracteres de longitud...
        $tipoError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $tipo_usuario)) === false ) {
        $tipoError = 'El nombre debe contener solo palabras.';
        $valid = false;
    }

    // Actualización de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE control_accesos SET clave_control_acceso = ?, tipo_usuario = ? WHERE id_control_acceso = ?;";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_control_acceso, $tipo_usuario, $id_control_acceso));
        Database::disconnect();
        header("Location: accesos.php");
    }
} else {
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM control_accesos where id_control_acceso = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_control_acceso));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $tipo_usuario = $data['tipo_usuario'];
    $clave_control_acceso = $data['clave_control_acceso'];
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
        <form class="form-horizontal" action="edit.php?id_control_acceso=<?php echo $id_control_acceso?>" method="post">
            <div class="control-group <?php echo !empty($claveError)?'error':'';?>">
                <label class="control-label">Clave de la beca</label>
                <div class="controls">
                    <input name="clave_control_acceso" type="text" placeholder="Clave de la beca" value="<?php echo !empty($clave_control_acceso)?$clave_control_acceso:'';?>">
                    <?php if (!empty($claveError)): ?>
                        <span class="help-inline"><?php echo $claveError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
                <label class="control-label">Nombre de la beca</label>
                <div class="controls">
                    <input name="tipo_usuario" type="text" placeholder="Nombre de la beca" value="<?php echo !empty($tipo_usuario)?$tipo_usuario:'';?>">
                    <?php if (!empty($nombreError)): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn" href="control_accesos.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
