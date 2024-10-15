<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Obtener el ID del cliente
$id = $_GET['id'];

// Obtener datos del cliente
$result = $conn->query("SELECT * FROM clientes WHERE id = $id");
$cliente = $result->fetch_assoc();

// Actualizar cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $localidad = $_POST['localidad'];
    $plan_id = $_POST['plan_id'];

    $sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', localidad='$localidad', plan_id=$plan_id WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente actualizado exitosamente.";
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
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">
    <h1>Editar Cliente</h1>
    <form action="editar_cliente.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" name="apellido" value="<?php echo $cliente['apellido']; ?>" required>
        </div>
        <div class="form-group">
            <label for="localidad">Localidad:</label>
            <input type="text" class="form-control" name="localidad" value="<?php echo $cliente['localidad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="plan_id">Plan:</label>
            <select class="form-control" name="plan_id" required>
                <?php while ($row = $planes->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $cliente['plan_id'] ? 'selected' : ''; ?>>
                        <?php echo $row['nombre_plan']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar Cliente</button>
    </form>
</body>
</html>
