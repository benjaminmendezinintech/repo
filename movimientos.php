<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_info = $_SESSION['user_info'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Sistema Financiero</title>    
    <link rel="stylesheet" href="css/styless.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/26bd214a86.js" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="container">
    <header class="header">
        <div class="logo">
        <a href="dashboard.php">
            <img src="img/Mountain.png" alt="Logo de la marca" >
        </a>
        </div>
        <nav>
           <ul class="nav-links">
           <li><a href="dashboard.php">Dashboard</a></li>
           <li><a href="consulta_movimientos.php">Consulta movimientos</a></li>
           <li><a href="usuarios.php">Usuarios</a></li>
           </ul>            
        </nav>
        <a class="btn" href='logout.php'><button>Salir</button></a>

        <a onclick="openNav()" class="menu" href="#"><button>Menu</button></a>

        <div id="mobile-menu" class="overlay">
            <a onclick="closeNav()" href="" class="close">&times;</a>
            <div class="overlay-content">
                <a href="dashboard.php">Dashboard</a>
                <a href="consulta_movimientos.php">Consulta Movimientos</a>
                <a href="usuarios.php">Usuarios</a>
                <a href="logout.php">Salir</a>
            </div>
        </div>

    </header>
 <script type="text/javascript" src="js/nav.js"></script>
 <!-------- Formulario Registrar Movimiento---------------------->
     <div class="title"> Registrar Movimiento</div>
        <div class="content">
        <form action="insertar_movimientos.php" method="POST">
        <div class="input-box">
            <span class="details">ID Tercero:</span>
                <select name="ID_TERCERO" id="ID_TERCERO" required>
                    <option value="">Seleccione un Tercero</option>
                        <?php
                        // Conexión a la base de datos
                        include 'includes/configuration.php';
                    
                        $sql = "SELECT ID_TERCERO, NOM_TERCERO, APE_PATERNO, APE_MATERNO FROM CAT_TERCEROS"; // Cambia la tabla y campos según tu base de datos
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ID_TERCERO'] . "'>" . htmlspecialchars($row['NOM_TERCERO'])." " .htmlspecialchars($row['APE_PATERNO']).  " ". htmlspecialchars($row['APE_MATERNO']) . "</option>";
                        }
                        $conn->close();
                        ?>
                </select>
        </div>

        <div class="input-box">
            <span class="details">Tipo de tercero:</span>
                <select name="TIP_TERCERO" id="TIP_TERCERO" required>
                    <option value="1">Accionista</option>
                    <option value="2">Prestuario</option>
                    <!-- Puedes añadir más tipos de movimiento aquí -->
            </select>
        </div>

        <div class="input-box">
            <span class="details">Tipo de Movimiento:</span>
                <select name="COD_MOVIMIENTO" id="COD_MOVIMIENTO" required>
                    <option value="">Seleccione un MOVIMIENTO</option>
                        <?php
                            // Conexión a la base de datos
                            include 'includes/configuration.php';
                            $sql = "SELECT COD_MOVIMIENTO, DESC_MOVIMIENTO FROM CAT_TIP_MOVIMIENTOS"; // Cambia la tabla y campos según tu base de datos
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['COD_MOVIMIENTO'] . "'>" . htmlspecialchars($row['DESC_MOVIMIENTO']) . "</option>";
                            }
                            $conn->close();
                            ?>
                </select>
        </div>

        <div class="input-box">
            <span class="details">Importe de Retiro:</span>
            <input type="number" step="0.01" name="IMP_RETIRO" id="IMP_RETIRO" placeholder="Importe del retiro">
        </div>
        
        <div class="input-box">
            <span class="details">Importe de Depósito:</span>
            <input type="number" step="0.01" name="IMP_DEPOSITO" id="IMP_DEPOSITO" placeholder="Importe del Deposito">
        </div>
    
<script>
document.getElementById('COD_MOVIMIENTO').addEventListener('change', function() {
    var depositoInput = document.getElementById('IMP_DEPOSITO');
    var retiroInput = document.getElementById('IMP_RETIRO');

    // Opciones que inhabilitan el campo IMP_DEPOSITO
    var disableDepositoOptions = ['2', '6']; // Cambia estos valores según tu lógica
    // Opciones que inhabilitan el campo IMP_RETIRO
    var disableRetiroOptions = ['1', '3', '4', '5']; // Cambia estos valores según tu lógica

    // Deshabilitar IMP_DEPOSITO si se selecciona un préstamo
    if (disableDepositoOptions.includes(this.value)) {
        depositoInput.disabled = true;
        depositoInput.value = ''; // Limpia el valor del input inhabilitado
    } else {
        depositoInput.disabled = false; // Habilita el input de depósito
    }

    // Deshabilitar IMP_RETIRO si se selecciona un movimiento específico
    if (disableRetiroOptions.includes(this.value)) {
        retiroInput.disabled = true;
        retiroInput.value = ''; // Limpia el valor del input inhabilitado
    } else {
        retiroInput.disabled = false; // Habilita el input de retiro
    }
});
</script>   

        <div class="input-box">
            <span class="details">Inhabilitado:</span>
                <select name="MCA_INHABILITADO" id="MCA_INHABILITADO" required>
                    <option value="N">NO</option>
                    <option value="Y">SI</option>
                </select>
        </div>
        <div class="button">
          <input type="submit" value="Register">
        </div>
        </form>
    </div>
  </div>

<script>
document.getElementById('COD_MOVIMIENTO').addEventListener('change', function() {
    var depositoInput = document.getElementById('IMP_DEPOSITO');
    var retiroInput = document.getElementById('IMP_RETIRO');

    // Opciones que inhabilitan el campo IMP_DEPOSITO
    var disableDepositoOptions = ['2', '6']; // Asumiendo que estos son los valores de los tipos de movimiento

    // Opciones que inhabilitan el campo IMP_RETIRO
    var disableRetiroOptions = ['1', '3', '4', '5']; // Asumiendo que estos son los valores de los tipos de movimiento

    // Deshabilitar IMP_DEPOSITO si se selecciona un préstamo
    if (disableDepositoOptions.includes(this.value)) {
        depositoInput.disabled = true;
        depositoInput.value = ''; // Limpia el valor del input inhabilitado
    } else {
        depositoInput.disabled = false; // Habilita el input de depósito
    }

    // Deshabilitar IMP_RETIRO si se selecciona un movimiento específico
    if (disableRetiroOptions.includes(this.value)) {
        retiroInput.disabled = true;
        retiroInput.value = ''; // Limpia el valor del input inhabilitado
    } else {
        retiroInput.disabled = false; // Habilita el input de retiro
    }
});
</script>
</body>
</html>

