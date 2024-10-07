<?php
session_start();
require_once 'includes/configuration.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_info = $_SESSION['user_info'];
$ID_TERCERO = ['ID_TERCERO'];
$NOM_TERCERO = ['NOM_TERCERO'];
$APE_MATERNO = ['APE_MATERNO'];
$APE_PATERNO = ['APE_PATERNO'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Sistema Financiero</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/styless.css">
    <link rel="stylesheet" href="css/botton.css">
    <style>
        /* Alternar el color de fondo de las filas */
        .table tbody tr:nth-child(odd) {
            background-color: #e3f2fd; /* Azul claro para filas impares */
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff; /* Blanco para filas pares */
        }

        .table tbody tr td {
            color: #000; /* Color de texto negro */
            padding: 8px; /* Espaciado de las celdas */
            text-align: center; /* Centrar el texto */
            border: 1px solid #f1f1f1; /* Borde de las celdas */
        }
        button {
            border: 2px solid;
            border-radius: 9px;
            cursor: pointer;
            margin: 0 10px;
            padding: 1rem 3rem;
            font-weight: bold;
            font-size: 1rem;
}

    </style>
    <script src="https://kit.fontawesome.com/26bd214a86.js" crossorigin="anonymous"></script>
</head>
<body>
<header class="header">
    <div class="logo">
        <a href="dashboard.php">
            <img src="img/Mountain.png" alt="Logo de la marca">
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

<?php
$sql = "SELECT ID_TERCERO, NOM_TERCERO, APE_PATERNO, APE_MATERNO FROM CAT_TERCEROS ORDER BY ID_TERCERO ASC";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos
if ($result->num_rows > 0) {
?>
 
<div class="table-container">
    <h1>LISTADO DE USUARIOS</h1>
    <div class="contenido1">    
        <a href="movimientos.php">
            <button class="btn_1"><i class="fa-solid fa-table"></i> Movimientos</button>
        </a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID_TERCERO</th>
                <th>NOMBRE</th>
                <th>APELLIDO PATERNO</th>
                <th>APELLIDO MATERNO</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td data-label="ID_TERCERO"><?php echo $row['ID_TERCERO']; ?></td>
                    <td data-label="NOMBRE"><?php echo $row['NOM_TERCERO']; ?></td>
                    <td data-label="APELLIDO PATERNO"><?php echo $row['APE_PATERNO']; ?></td>
                    <td data-label="APELLIDO MATERNO"><?php echo $row['APE_MATERNO']; ?></td>
                    <td data-label="">
                        <a href="reporte.php"><button class="btn_3"><i class="fa-regular fa-pen-to-square"></i></button></a>
                    </td>
                    <td data-label="">
                        <a href="reporte.php"><button class="btn_2"><i class="fa-solid fa-user-minus"></i></button></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
} else {
    echo "No se encontraron usuarios.";
}
// Cerrar la conexión
$conn->close();
?>
</body>
</html>
