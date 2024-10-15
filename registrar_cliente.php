<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Crear cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $localidad = $_POST['localidad'];
    $plan_id = $_POST['plan_id'];
    $fecha_registro = date('Y-m-d');

    $sql = "INSERT INTO clientes (nombre, apellido, localidad, plan_id, fecha_registro) 
            VALUES ('$nombre', '$apellido', '$localidad', $plan_id, '$fecha_registro')";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente creado exitosamente.";
        header("Location: gestionar_clientes.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener planes
$planes = $conn->query("SELECT * FROM planes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">
    <h1>Registrar Cliente</h1>
    <form action="registrar_cliente.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="localidad">Localidad:</label>
            <input type="text" class="form-control" name="localidad" required>
        </div>
        <div class="form-group">
            <label for="plan_id">Plan:</label>
            <select class="form-control" name="plan_id" required>
                <option value="">Seleccione un plan</option>
                <?php while ($row = $planes->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre_plan'] . ' - $' . number_format($row['mensualidad'], 2); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
    </form>
</body>
</html>
