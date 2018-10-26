<?php

// include ('../../views/header.php');
// include ('../../views/footer.php');

require '../../config/database.php';

$id_semestre = null;

if ( !empty($_GET['id_semestre']) ) {
    $id_semestre = $_REQUEST['id_semestre'];
}

if ( null == $id_semestre ) {
    header("Location: semestres.php");
}

if ( !empty($_POST) ) {
    // Definición de variable para capturar el dato de 'clave_semestre' directamente desde la base de datos
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM semestres where id_semestre = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_semestre));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $clave_semestre_compara = $data['clave_semestre'];
    Database::disconnect();

    // Definición de variables, capturando la información de los inputs
    $clave_semestre = null;
    $nombre_semestre = null;
    $clave_semestre = $_POST['clave_semestre'];
    $nombre_semestre = $_POST['nombre_semestre'];

    // Transforma a mayúsculas la variable 'clave_semestre'
    $clave_semestre = strtoupper($clave_semestre);

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM semestres WHERE clave_semestre = ?");
    $stmt -> execute([$clave_semestre]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'clave_semestre'
    $valid = true;
    if ( ($count > 0) && ($clave_semestre_compara != $clave_semestre) ) { // En caso de encontrar registro duplicados y permitir la sobreescritura del registro...
        $claveError = "La clave " . $clave_semestre . " ya existe.";
        $valid = false;
    } else if ( empty($clave_semestre) ) { // En caso de que el input esté vacío...
        $claveError = 'Por favor ingresa la clave para identificar el semestre.';
        $valid = false;
    } elseif ( strlen($clave_semestre) != 6 ) { // En caso de que 'clave_semestre' no sea de 2 caracteres de longitud...
        $claveError = 'La clave del semestre debe tener 6 caracteres.';
        $valid = false;
    } elseif ( !preg_match('/^[0-9]{4}-[A-B]{1}$/', $clave_semestre) ) { // En caso de que 'clave_semestre' no tenga el formato correcto...
        $claveError = 'La clave del semestre debe tener el siguiente formato: 4 numeros, seguidos de un guión, y después 1 letra A o B.';
        $valid = false;
    }

    // Validaciones de la variable 'nombre_semestre'
    if ( empty($nombre_semestre) ) { // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre del semestre.';
        $valid = false;
    } elseif ( strlen($nombre_semestre) > 40 ) { // En caso de que 'clave_semestre' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 40 caracteres.';
        $valid = false;
    }

    // Actualización de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE semestres SET clave_semestre = ?, nombre_semestre = ? WHERE id_semestre = ?;";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($clave_semestre, $nombre_semestre, $id_semestre));
        Database::disconnect();
        header("Location: semestres.php");
    }
} else {
    $pdo = Database::connect();
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM semestres where id_semestre = ?";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($id_semestre));
    $data = $q -> fetch(PDO::FETCH_ASSOC);
    $nombre_semestre = $data['nombre_semestre'];
    $clave_semestre = $data['clave_semestre'];
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
            <h3>Actualizar semestre</h3>
        </div>
        <form class="form-horizontal" action="edit.php?id_semestre=<?php echo $id_semestre?>" method="post">
            <div class="control-group <?php echo !empty($claveError)?'error':'';?>">
                <label class="control-label">Clave del semestre</label>
                <div class="controls">
                    <input name="clave_semestre" type="text" placeholder="Clave del semestre" value="<?php echo !empty($clave_semestre)?$clave_semestre:'';?>">
                    <?php if (!empty($claveError)): ?>
                        <span class="help-inline"><?php echo $claveError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
                <label class="control-label">Nombre del semestre</label>
                <div class="controls">
                    <input name="nombre_semestre" type="text" placeholder="Nombre del semestre" value="<?php echo !empty($nombre_semestre)?$nombre_semestre:'';?>">
                    <?php if (!empty($nombreError)): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn" href="semestres.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
