<?php

//include '../../views/header.php';
//include '../../views/footer.php';

require '../../config/database.php';

if ( !empty($_POST) ) {
    // Definición de variables, capturando la información de los inputs
    $nombre_usuario = null;
    $correo_electronico = null;
    $contrasena = null;
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $id_control_acceso = $_POST['tipo_usuario'];

    // VALIDACIONES
    // Validaciones de la variable 'clave_usuario'
    $valid = true;
    if ( empty($nombre_usuario) ) { // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre del usuario.';
        $valid = false;
    } elseif ( strlen($nombre_usuario) > 30 ) { // En caso de que 'clave_usuario' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $nombre_usuario)) === false ) {
        $nombreError = 'El nombre debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'correo_electronico'
    if ( empty($correo_electronico) ) { // En caso de que el input esté vacío...
        $correoError = 'Por favor ingresa el correo electronico.';
        $valid = false;
    } elseif ( strlen($correo_electronico) > 30 ) { // En caso de que 'correo_electronico' sea mayor de 30 caracteres de longitud...
        $correoError = 'El correo electrónico debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL) ) {
        $correoError = 'Ingrese un correo electrónico válido.';
        $valid = false;
    }

    // Validaciones de la variable 'contrasena'
    if ( empty($contrasena) ) { // En caso de que el input esté vacío...
        $contrasenaError = 'Por favor ingresa la contrasena del usuario.';
        $valid = false;
    } elseif ( (strlen($contrasena) < 6) || (strlen($contrasena) > 30) ) { // En caso de que 'contrasena' sea mayor de 30 caracteres de longitud...
        $contrasenaError = 'La contrasena debe ser de entre 6 a 30 caracteres.';
        $valid = false;
    }

    // Validaciones de la variable 'id_control_acceso'
    if ( empty($id_control_acceso) ) { // En caso de que el input esté vacío...
        $controlError = 'Por favor ingresa el tipo de usuario.';
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        // Declaracion de variable para encriptacion de contrasena
        $opt = [  'cost' => 12, ];
        $contrasena = password_hash($contrasena, PASSWORD_BCRYPT, $opt);

        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, id_control_acceso) values(?, ?, ?, ?)";
        $q = $pdo -> prepare($sql);
        $q -> execute(array( $nombre_usuario, $correo_electronico, $contrasena, $id_control_acceso));
        Database::disconnect();
        header("Location: usuarios.php");
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
            <h3>Agregar nuevo usuario</h3>
        </div>
        <form class="form-horizontal" action="new.php" method="post">

            <div class="control-group <?php echo !empty( $nombreError )?'error':'';?>">
                <label class="control-label">Nombre del usuario</label>
                <div class="controls">
                    <input name="nombre_usuario" type="text" placeholder="Nombre del usuario" value="<?php echo !empty( $nombre_usuario )?$nombre_usuario:'';?>">
                    <?php if ( !empty($nombreError) ): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $correoError )?'error':'';?>">
                <label class="control-label">Correo electrónicio</label>
                <div class="controls">
                    <input name="correo_electronico" type="text" placeholder="Correo electrónicio" value="<?php echo !empty( $correo_electronico )?$correo_electronico:'';?>">
                    <?php if ( !empty($correoError) ): ?>
                        <span class="help-inline"><?php echo $correoError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $contrasenaError )?'error':'';?>">
                <label class="control-label">Contraseña</label>
                <div class="controls">
                    <input name="contrasena" type="password" placeholder="Contraseña" value="<?php echo !empty( $contrasena )?$contrasena:'';?>">
                    <?php if ( !empty($contrasenaError) ): ?>
                        <span class="help-inline"><?php echo $contrasenaError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $controlError )?'error':'';?>">
                <label class="control-label">Tipo de usuario</label>
                <div class="controls">
                    <select name="tipo_usuario">
                        <?php
                        // Contador para encontrar registros duplicados
                        $pdo = Database::connect();
                        $stmt = $pdo -> prepare("SELECT id_control_acceso, tipo_usuario FROM control_accesos ORDER BY id_control_acceso;");
                        $stmt -> execute( );
                        $list = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ( $list as $output ) {
                            echo '<option value="'.$output['id_control_acceso'].'">'.$output['tipo_usuario'].'</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <?php if ( !empty($controlError) ): ?>
                        <span class="help-inline"><?php echo $controlError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Agregar</button>
                <a class="btn" href="usuarios.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
