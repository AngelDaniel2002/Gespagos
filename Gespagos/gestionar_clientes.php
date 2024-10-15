<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Eliminar cliente
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM clientes WHERE id = $id");
}

// Obtener todos los clientes
$clientes = $conn->query("SELECT c.id, c.nombre, c.apellido, c.localidad, p.nombre_plan 
                           FROM clientes c 
                           JOIN planes p ON c.plan_id = p.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">
    <h1>Gestionar Clientes</h1>
    <a href="registrar_cliente.php" class="btn btn-primary mb-3">Registrar Nuevo Cliente</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Localidad</th>
                <th>Plan</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $clientes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['localidad']; ?></td>
                    <td><?php echo $row['nombre_plan']; ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
