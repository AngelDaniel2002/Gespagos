<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Obtener clientes que pagan antes de hoy, hoy y próximos
$hoy = date('Y-m-d');
$clientes_pagos = $conn->query("SELECT c.id, c.nombre, c.apellido, c.localidad, p.nombre_plan, p.mensualidad, pg.fecha_pago, pg.recargo 
                                  FROM clientes c 
                                  JOIN planes p ON c.plan_id = p.id 
                                  LEFT JOIN pagos pg ON c.id = pg.cliente_id 
                                  WHERE pg.fecha_pago < '$hoy' 
                                  OR pg.fecha_pago = '$hoy' 
                                  OR pg.fecha_pago IS NULL");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">
    <h1>Gestión de Clientes</h1>
    <div class="mb-3">
        <a href="gestionar_clientes.php" class="btn btn-primary">Gestionar Clientes</a>
        <a href="registrar_pago.php" class="btn btn-secondary">Registrar Pago</a>
    </div>
    
    <h2>Clientes y Pagos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Localidad</th>
                <th>Plan</th>
                <th>Mensualidad</th>
                <th>Fecha de Pago</th>
                <th>Recargo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $clientes_pagos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['localidad']; ?></td>
                    <td><?php echo $row['nombre_plan']; ?></td>
                    <td><?php echo $row['mensualidad']; ?></td>
                    <td><?php echo $row['fecha_pago'] ?? 'No Pagado'; ?></td>
                    <td><?php echo $row['recargo'] ? $row['recargo'] : '0'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
