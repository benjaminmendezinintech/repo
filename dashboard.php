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
    <link rel="stylesheet" href="css/body.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="container">
      <div class="logo">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="32.519"
          height="30.7"
          viewBox="0 0 32.519 30.7"
          fill="#363b46"
        >
          <g id="Logo" transform="translate(-90.74 -84.875)">
            <path
              id="B"
              d="M14.378-30.915c-5.124,0-9.292,3.767-9.292,10.228S9.254-10.46,14.378-10.46h1.471c5.124,0,9.292-3.767,9.292-10.228s-4.168-10.228-9.292-10.228H14.378M11.7-33.456h6.819A12.768,12.768,0,0,1,31.29-20.687,12.768,12.768,0,0,1,18.522-7.919H11.7A12.768,12.768,0,0,1-1.065-20.687C-2.4-51.282,4.652-33.456,11.7-33.456Z"
              transform="translate(91.969 123.494)"
            />
          </g>
        </svg>
      </div>
      <ul class="link-items">
      <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="cube-outline"></ion-icon>
            <span style="--i: 2">Dashboard</span>
          </a>
        </li>
        <li class="link-item">
          <a href="consulta_movimientos.php" class="link">
          <ion-icon name="swap-horizontal-outline"></ion-icon>
          <span style="--i: 5">Mis movimientos</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
          <ion-icon name="people-outline"></ion-icon>
            <span style="--i: 2">Usuarios</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon class="noti-icon" name="notifications-outline"></ion-icon>
            <span style="--i: 4">notifications</span>
            <span class="num-noti">4</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="cog-outline"></ion-icon>
            <span style="--i: 6">settings</span>
          </a>
        </li>
        <li class="link-item dark-mode">
          <a href="#" class="link">
            <ion-icon name="moon-outline"></ion-icon>
            <span style="--i: 8">dark mode</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <img src="user.png" alt="" />
            <span style="--i: 9">
              <h4>John Doe</h4>
              <p>web developer</p>
            </span>
          </a>
        </li>
        <li class="link-item">
          <a href="logout.php" class="link">
          <ion-icon name="log-out-outline"></ion-icon>
            <span style="--i: 9">
              <h4>Salir</h4>
            </span>
          </a>
        </li>
      </ul>
    </div>
<!---------------------------------------------------------------------------->
<div class="main-content">
    <div class="status-container">
        <div class="status-box">
            <h4>Bienvenido <?php echo $nombre_completo; ?></h4>

         <!-- Aquí se cargará el estado del ahorro -->
        </div>
</div>

<div class="main-content">
    <div class="status-container">
        <div class="status-box">
            <h4>Estado del Ahorro</h4>
            <p id="ahorro-estado">Cargando...</p> <!-- Aquí se cargará el estado del ahorro -->
        </div>
        <div class="status-box">
            <h4>Estado del Préstamo</h4>
            <p id="prestamo-estado">Cargando...</p> <!-- Aquí se cargará el estado del préstamo -->
        </div>
        <div class="status-box">
            <h4>Rendimiento del Interés Anual</h4>
            <p id="interes-estado">Cargando...</p> <!-- Aquí se cargará el rendimiento del interés -->
        </div>
    </div>

    <div class="chart-container">
        <canvas id="ahorro-chart"></canvas> <!-- Aquí irá el gráfico -->
    </div>
</div>

<!---------------------------------------------------------------------------->
   
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <script src="nav.js"></script>

</body>
</html>



