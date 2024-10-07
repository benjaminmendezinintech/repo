<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user_info = $_SESSION['user_info'];
$movimientos = [];
$nombre_completo = $user_info['NOM_TERCERO'] . ' ' . $user_info['APE_PATERNO'] . ' ' . $user_info['APE_MATERNO'];
$saldo_total = 0;
$suma_depositos = 0;
$suma_retiros = 0;
$sumatorias_por_tipo = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" || $user_info['COD_PERMISOS'] != '99') {
    if ($user_info['COD_PERMISOS'] == '99') {
        $id_tercero = $_POST['id_tercero'];
        $tip_tercero = $_POST['tip_tercero'];
    } else {
        $id_tercero = $user_info['ID_TERCERO'];
        $tip_tercero = $user_info['TIP_TERCERO'];
    }

    $movimientos = get_movimientos($id_tercero, $tip_tercero);
    
    $saldo_acumulado = 0;
    foreach ($movimientos as $key => $mov) {
        $imp_retiro = floatval($mov['IMP_RETIRO']);
        $imp_deposito = floatval($mov['IMP_DEPOSITO']);
        
        $saldo_acumulado += $imp_deposito + $imp_retiro;
        $movimientos[$key]['SALDO'] = $saldo_acumulado;
        
        $suma_depositos += $imp_deposito;
        $suma_retiros += $imp_retiro;
        
        $tipo_movimiento = $mov['DESC_MOVIMIENTO'];
        if (!isset($sumatorias_por_tipo[$tipo_movimiento])) {
            $sumatorias_por_tipo[$tipo_movimiento] = 0;
        }
        $sumatorias_por_tipo[$tipo_movimiento] += $imp_deposito + $imp_retiro;
    }
    $saldo_total = $saldo_acumulado;
    
    // Añadir el concepto 'Prestamo por liquidar:' al final de las sumatorias
    $prestamo_por_liquidar = $sumatorias_por_tipo['PRESTAMO:'] ?? 0;
    $sumatorias_por_tipo['Prestamo por liquidar:'] = $prestamo_por_liquidar;
}

function formatDate($date) {
    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    return $dateObj->format('d-M-Y');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Movimientos - Sistema Financiero</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/styless.css">
    <link rel="stylesheet" href="css/botton.css">
    <script src="https://kit.fontawesome.com/26bd214a86.js" crossorigin="anonymous"></script>

    <style>
        .table tbody tr:nth-child(even) {
            background-color: #e3f2fd; /* Azul claro */
        }

        .table tbody tr:nth-child(odd) {
            background-color: #ffffff; /* Blanco */
        }

        .table tbody tr td {
            color: #000; /* Color de texto negro */
            padding: 8px;
            text-align: center; /* Ajusta según tus necesidades */
            border: 1px solid #f1f1f1; /* Ajusta este valor si es necesario */
        }
    </style>
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

<div class="table-container">
    <h2>Consulta de Movimientos</h2>
    <?php if ($user_info['COD_PERMISOS'] == '99'): ?>
        <form method="post">
            <label for="id_tercero">ID Tercero:</label>
            <input type="text" id="id_tercero" name="id_tercero" required><br><br>
            <label for="tip_tercero">Tipo de Tercero:</label>
            <input type="text" id="tip_tercero" name="tip_tercero" required><br><br>
            <input type="submit" value="Consultar">
        </form>
    <?php endif; ?>
    
    <?php if (!empty($movimientos)): ?>
        <h3>Estado de Cuenta</h3>
        <p><strong>Cliente:</strong> <?php echo $nombre_completo; ?></p>
        <p><strong>Periodo:</strong> <?php echo formatDate($movimientos[0]['FEC_REGISTRO']) . ' al ' . formatDate(end($movimientos)['FEC_REGISTRO']); ?></p>
        <p><strong>Fecha de emisión:</strong> <?php echo date('d-M-Y H:i:s'); ?></p>


        <div class="contenido1">
            <a href="reporte.php">
                <button class="btn_1"><i class="fa-solid fa-file-arrow-down"></i>Download</button>
            </a>
        </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Retiros</th>
                        <th>Depósitos</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $index => $mov): ?>
                        <tr>
                            <td data-label="Fecha"><?php echo formatDate($mov['FEC_REGISTRO']); ?></td>
                            <td data-label="Concepto"><?php echo $mov['DESC_MOVIMIENTO']; ?></td>
                            <td data-label="Retiros"><?php echo ($mov['IMP_RETIRO'] != 0 && $mov['IMP_RETIRO'] !== null) ? number_format($mov['IMP_RETIRO'], 2) : ''; ?></td>
                            <td data-label="Depósitos"><?php echo ($mov['IMP_DEPOSITO'] != 0 && $mov['IMP_DEPOSITO'] !== null) ? number_format($mov['IMP_DEPOSITO'], 2) : ''; ?></td>
                            <td data-label="Saldo"><?php echo number_format($mov['SALDO'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
   
        <div class="table-container">
            <h4>Sumatorias por tipo de movimiento:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Concepto</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sumatorias_por_tipo as $tipo => $suma): ?>
                        <tr>
                            <td data-label="Concepto"><?php echo $tipo; ?></td>
                            <td data-label="Importe"><?php echo number_format($suma, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    
            <p><strong>Suma total de depósitos:</strong> $<?php echo number_format($suma_depositos, 2); ?></p>
            <p><strong>Suma total de retiros:</strong> $<?php echo number_format($suma_retiros, 2); ?></p>
            <p><strong>Saldo final:</strong> $<?php echo number_format($saldo_total, 2); ?></p>
        </div>
    <?php elseif ($user_info['COD_PERMISOS'] != '99'): ?>
        <p>No se encontraron movimientos para este usuario.</p>
    <?php endif; ?>
</body>
</html>
