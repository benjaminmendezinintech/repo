<?php
session_start();
if (!isset($_SESSION['user'])) {
  
}

$user_info = $_SESSION['user_info'];
$nombre_completo = $user_info['NOM_TERCERO'] . ' ' . $user_info['APE_PATERNO'] . ' ' . $user_info['APE_MATERNO'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Financiero</title>
    <link rel="stylesheet" href="css/styless.css">
</head>
<body>
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


<!---->    <script type="text/javascript" src="js/nav.js"></script>
<section>
    <div class="body-table">
        <div class="container"> 
        <h2>Bienvenido, <?php echo $nombre_completo; ?></h2>
            <h1>El total de tus ahorros</h1>
           
        </div>
    </div>
    
</section>

</body>
</html>
