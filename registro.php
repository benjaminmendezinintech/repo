<?php
include 'includes/configuration.php';
session_start();
if (!isset($_SESSION['user'])) {
  
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// CAT_USUARIO CAT_TERCEROS
    $COD_USUARIO = $_POST['COD_USUARIO'];
    $CORREO_USUARIO =$_POST['CORREO_USUARIO'];
    $TIP_USUARIO = "ACC";
    $COD_PERMISOS = 1;
    $COD_PASS = password_hash($_POST['COD_PASS'], PASSWORD_BCRYPT);
    date_default_timezone_set('America/Mexico_City');
    $FEC_ACTUALIZACION = date('Y-m-d');
    $MCA_INHABILITADO = "N";

///// CAT_TERCEROS
$fecha_actual = date("Y-m");
$year_month = date("Ym"); // Formato YYYYMM
// Obtener el último ID insertado para determinar el nuevo número
$sql = "SELECT ID_TERCERO FROM CAT_TERCEROS WHERE ID_TERCERO LIKE '$year_month-%' ORDER BY ID_TERCERO DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Extraer el último ID
    $row = $result->fetch_assoc();
    $ultimo_id = $row['ID_TERCERO'];
    
    // Extraer el número al final del ID
    $numero = (int)substr($ultimo_id, -1); // Obtener el último dígito
    $nuevo_numero = $numero + 1; // Incrementar el número
} else {
    // Si no hay registros, iniciar en 1
    $nuevo_numero = $year_month . '-'. 1 ;
}

// Formatear el nuevo ID
$nuevo_id = $year_month . '-' . $nuevo_numero;

// Valor a insertarA<
    $ID_TERCERO =  $nuevo_numero; // Ejemplo de valor
    $TIP_TERCERO = 1;
    $NOM_TERCERO= $_POST['NOM_TERCERO'];
    $APE_MATERNO=$_POST['APE_MATERNO'];
    $APE_PATERNO=$_POST['APE_PATERNO'];
    
    $sql = "INSERT INTO CAT_USUARIOS (COD_USUARIO,CORREO_USUARIO,TIP_USUARIO,COD_PERMISOS, COD_PASS, FEC_ACTUALIZACION, MCA_INHABILITADO) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $COD_USUARIO,$CORREO_USUARIO, $TIP_USUARIO,$COD_PERMISOS, $COD_PASS, $FEC_ACTUALIZACION, $MCA_INHABILITADO);
    $stmt->execute();     
    $stmt->close();

        /// CAT_TER_USUARIOS

    $sql = "INSERT INTO CAT_TER_USUARIO (COD_USUARIO, ID_TERCERO, TIP_TERCERO, FEC_ACTUALIZACION, MCA_INHABILITADO) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $COD_USUARIO,$ID_TERCERO, $TIP_TERCERO, $FEC_ACTUALIZACION, $MCA_INHABILITADO);
    $stmt->execute();
    $stmt->close();

    $sql = "INSERT INTO CAT_TERCEROS (ID_TERCERO,TIP_TERCERO, NOM_TERCERO, APE_PATERNO, APE_MATERNO,FEC_ACTUALIZACION, MCA_INHABILITADO) VALUES (?, ?,  ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $ID_TERCERO, $TIP_TERCERO, $NOM_TERCERO, $APE_PATERNO, $APE_MATERNO, $FEC_ACTUALIZACION, $MCA_INHABILITADO);
    if ($stmt->execute()) {
        echo'<script type="text/javascript">
        alert("Tarea Guardada");
        </script>';
       } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();


}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
 
</head>

<body>
    <div class="contenedor-formulario contenedor">
        <div class="imagen-formulario">
        </div>
        <form method="post" class="formulario">
            <div class="texto-formulario">
                <h2>¡Bienvenido registrate!</h2>
                <p>Por favor ingresa tus datos</p>
            </div>
            <div class="input">
                <label for="usuario">Nombre</label>
                <input type="text" name="NOM_TERCERO" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="input">
                <label for="usuario">Apellidos</label>
                <input type="text" name="APE_PATERNO" placeholder="Ingresa tu apellido paterno" required>
            </div>
           <div class="input">
                <label for="usuario"></label>
                <input type="text" name="APE_MATERNO" placeholder="Ingresa tu apellido materno" required>
            </div>
            <div class="input">
                <label for="usuario">USUARIO</label>
                <input type="text" name="COD_USUARIO" placeholder="Ingresa tu correo" required>
            </div>
            <div class="input">
                <label for="usuario">Correo</label>
                <input type="correo" name="CORREO_USUARIO" placeholder="Ingresa tu correo" required>
            </div>
            <div class="input">
                <label for="contraseña">Contraseña</label>
                <input  type="password" id="password" name="COD_PASS" placeholder="Ingresa tu conteseña" required>
            </div>
            <div class="input">
            <input type="submit" value="Registrar">
            </div>
            <div class="input">
            <a href="index.php"> 
                <input type="button" value="Login">
            </a>
            </div>
        </form>

     
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="js/sweetAlert.js"></script> -->
</body>

</html>