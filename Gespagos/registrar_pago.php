<?php
include 'conexion.php'; // Incluir la conexión a la base de datos

// Registrar pago
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $fecha_pago = $_POST['fecha_pago'];
    $monto = $_POST['monto'];

    // Verificar si hay recargo
    $resultado = $conn->query("SELECT fecha_pago FROM clientes WHERE id = $cliente_id");
    $cliente = $resultado->fetch_assoc();
    $fecha_pago_cliente = new DateTime($cliente['fecha_pago']);
    $fecha_pago_nueva = new DateTime($fecha_pago);
    $diferencia = $fecha_pago_nueva->diff($fecha_pago_cliente)->days;

    $recargo = 0;
    if ($diferencia > 2) {
        $recargo = 50.00; // Aplicar recargo
    }

    $sql = "INSERT INTO pagos (cliente_id, fecha_pago, monto, recargo) 
            VALUES ($cliente_id, '$fecha_pago', $monto, $recargo)";

    if ($conn->query($sql) === TRUE) {
        echo "Pago registrado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener clientes
$clientes = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pago</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container">
    <h1>Registrar Pago</h1>
    <form action="registrar_pago.php" method="POST">
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select class="form-control" name="cliente_id" required>
                <?php while ($row = $clientes->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_pago">Fecha de Pago:</label>
            <input type="date" class="form-control" name="fecha_pago" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" class="form-control" name="monto" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Pago</button>
    </form>
</body>
</html>
