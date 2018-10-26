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
    $correo_electronico = null;
    $id_beca = null;
    $id_carrera = null;
    $id_estado = null;
    $matricula = $_POST['matricula'];
    $nombre_alumno = $_POST['nombre_alumno'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $correo_electronico = $_POST['correo_electronico'];
    $id_beca = $_POST['id_beca'];
    $id_carrera = $_POST['id_carrera'];
    $id_estado = $_POST['id_estado'];

    // Contador para encontrar registros duplicados
    $pdo = Database::connect();
    $stmt = $pdo -> prepare("SELECT count(*) FROM alumnos WHERE matricula = ?");
    $stmt -> execute([$matricula]);
    $count = $stmt -> fetchColumn();
    Database::disconnect();

    // VALIDACIONES
    // Validaciones de la variable 'matricula'
    $valid = true;
    if ( $count > 0 ) { // En caso de encontrar registro duplicados...
        $matriculaError = "La clave " . $matricula . " ya existe.";
        $valid = false;
    } else if ( empty($matricula) ) { // En caso de que el input esté vacío...
        $matriculaError = 'Por favor ingresa la matricula que identificar al alumno.';
        $valid = false;
    } elseif ( strlen($matricula) != 6 ) { // En caso de que 'matricula' no sea de 6 caracteres de longitud...
        $matriculaError = 'La clave de la alumno debe tener 6 caracteres.';
        $valid = false;
    } elseif ( !preg_match('/^[0-9]+$/', $matricula) ) { // En caso de que la 'matricula' no sea numerica...
        $matriculaError = 'La clave debe contener solo números.';
        $valid = false;
    }

    // Validaciones de la variable 'nombre_alumno'
    if ( empty($nombre_alumno) ) { // En caso de que el input esté vacío...
        $nombreError = 'Por favor ingresa el nombre del alumno.';
        $valid = false;
    } elseif ( strlen($nombre_alumno) > 30 ) { // En caso de que 'clave_usuario' sea mayor de 30 caracteres de longitud...
        $nombreError = 'El nombre debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $nombre_alumno)) === false ) {
        $nombreError = 'El nombre debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'apellido_paterno'
    if ( empty($apellido_paterno) ) { // En caso de que el input esté vacío...
        $apellidoPError = 'Por favor ingresa el apellido paterno del alumno.';
        $valid = false;
    } elseif ( strlen($apellido_paterno) > 30 ) { // En caso de que 'clave_usuario' sea mayor de 30 caracteres de longitud...
        $apellidoPError = 'El apellido paterno debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $apellido_paterno)) === false ) {
        $apellidoPError = 'El apellido paterno debe contener solo letras.';
        $valid = false;
    }

    // Validaciones de la variable 'apellido_materno'
    if ( empty($apellido_materno) ) { // En caso de que el input esté vacío...
        $apellidoMError = 'Por favor ingresa el apellido materno del alumno.';
        $valid = false;
    } elseif ( strlen($apellido_materno) > 30 ) { // En caso de que 'clave_usuario' sea mayor de 30 caracteres de longitud...
        $apellidoMError = 'El apellido materno debe ser menor a 30 caracteres.';
        $valid = false;
    } elseif ( ctype_alpha(str_replace(' ', '', $apellido_materno)) === false ) {
        $apellidoMError = 'El apellido materno debe contener solo letras.';
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

    // Validaciones de la variable 'id_beca'
    if ( empty($id_beca) ) { // En caso de que el input esté vacío...
        $becaError = 'Por favor ingresa la beca.';
        $valid = false;
    }

    // Validaciones de la variable 'id_carrera'
    if ( empty($id_carrera) ) { // En caso de que el input esté vacío...
        $carreraError = 'Por favor ingresa la carrera.';
        $valid = false;
    }

    // Validaciones de la variable 'id_estado'
    if ( empty($id_estado) ) { // En caso de que el input esté vacío...
        $estadoError = 'Por favor ingresa el estado.';
        $valid = false;
    }

    // Registro de los datos
    if ( $valid ) {
        $pdo = Database::connect();
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO alumnos (matricula, nombre_alumno, apellido_paterno, apellido_materno, correo_electronico, id_beca, id_carrera, id_estado) values(?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo -> prepare($sql);
        $q -> execute(array($matricula, $nombre_alumno, $apellido_paterno, $apellido_materno, $correo_electronico, $id_beca, $id_carrera, $id_estado));
        Database::disconnect();
        header("Location: alumnos.php");
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
            <h3>Agregar nuevo alumno</h3>
        </div>
        <form class="form-horizontal" action="new.php" method="post">

            <div class="control-group <?php echo !empty( $matriculaError )?'error':'';?>">
                <label class="control-label">Matricula</label>
                <div class="controls">
                    <input name="matricula" type="text" placeholder="Matricula" value="<?php echo !empty( $matricula )?$matricula:'';?>">
                    <?php if ( !empty($matriculaError) ): ?>
                        <span class="help-inline"><?php echo $matriculaError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $nombreError )?'error':'';?>">
                <label class="control-label">Nombre(s)</label>
                <div class="controls">
                    <input name="nombre_alumno" type="text" placeholder="Nombre(s)" value="<?php echo !empty( $nombre_alumno )?$nombre_alumno:'';?>">
                    <?php if ( !empty($nombreError) ): ?>
                        <span class="help-inline"><?php echo $nombreError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $apellidoPError )?'error':'';?>">
                <label class="control-label">Apellido paterno</label>
                <div class="controls">
                    <input name="apellido_paterno" type="text" placeholder="Apellido paterno" value="<?php echo !empty( $apellido_paterno )?$apellido_paterno:'';?>">
                    <?php if ( !empty($apellidoPError) ): ?>
                        <span class="help-inline"><?php echo $apellidoPError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $apellidoMError )?'error':'';?>">
                <label class="control-label">Apellido materno</label>
                <div class="controls">
                    <input name="apellido_materno" type="text" placeholder="Apellido materno" value="<?php echo !empty( $apellido_materno )?$apellido_materno:'';?>">
                    <?php if ( !empty($apellidoMError) ): ?>
                        <span class="help-inline"><?php echo $apellidoMError;?></span>
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

            <div class="control-group <?php echo !empty( $becaError )?'error':'';?>">
                <label class="control-label">Beca asignada</label>
                <div class="controls">
                    <select name="id_beca">
                        <?php
                        // Contador para encontrar registros duplicados
                        $pdo = Database::connect();
                        $stmt = $pdo -> prepare("SELECT id_beca, clave_beca, nombre_beca FROM becas ORDER BY id_beca;");
                        $stmt -> execute( );
                        $list = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ( $list as $output ) {
                            echo '<option value="'.$output['id_beca'].'">'.$output['clave_beca'].' - '.$output['nombre_beca'].'</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <?php if ( !empty($becaError) ): ?>
                        <span class="help-inline"><?php echo $becaError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $carreraError )?'error':'';?>">
                <label class="control-label">Carrera</label>
                <div class="controls">
                    <select name="id_carrera">
                        <?php
                        // Contador para encontrar registros duplicados
                        $pdo = Database::connect();
                        $stmt = $pdo -> prepare("SELECT id_carrera, clave_carrera, nombre_carrera FROM carreras ORDER BY id_carrera;");
                        $stmt -> execute( );
                        $list = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ( $list as $output ) {
                            echo '<option value="'.$output['id_carrera'].'">'.$output['clave_carrera'].' - '.$output['nombre_carrera'].'</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <?php if ( !empty($carreraError) ): ?>
                        <span class="help-inline"><?php echo $carreraError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty( $estadoError )?'error':'';?>">
                <label class="control-label">Estado</label>
                <div class="controls">
                    <select name="id_estado">
                        <?php
                        // Contador para encontrar registros duplicados
                        $pdo = Database::connect();
                        $stmt = $pdo -> prepare("SELECT id_estado, clave_estado, nombre_estado FROM estados ORDER BY id_estado;");
                        $stmt -> execute( );
                        $list = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ( $list as $output ) {
                            echo '<option value="'.$output['id_estado'].'">'.$output['clave_estado'].' - '.$output['nombre_estado'].'</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <?php if ( !empty($estadoError) ): ?>
                        <span class="help-inline"><?php echo $estadoError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Agregar</button>
                <a class="btn" href="alumnos.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>
