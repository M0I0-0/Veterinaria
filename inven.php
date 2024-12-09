<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Fecha actual
$fecha_actual = date('Y-m-d');

// Consulta para obtener los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Almacenar alertas para productos próximos a caducar
$alertas = [];

while ($row = $result->fetch_assoc()) {
    $fecha_caducidad = isset($row["Fec_Cad"]) ? $row["Fec_Cad"] : null;
    if ($fecha_caducidad) {
        $dias_restantes = (strtotime($fecha_caducidad) - strtotime($fecha_actual)) / 86400;
        if ($dias_restantes > 0 && $dias_restantes <= 5) {
            $alertas[] = "El producto '" . $row["Nomb_Prod"] . "' está próximo a vencer (Fecha de Caducidad: " . $fecha_caducidad . ").";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            box-sizing: border-box;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1500px;
            margin: 40px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            color: #3f51b5;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 20px;
            text-align: left;
        }

        th {
            background-color: #3f51b5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-results {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
            padding: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3f51b5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }

        .btn:hover {
            background-color: #303f9f;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 80%;
            max-width: 400px;
        }

        .modal-content h2 {
            color: #3f51b5;
        }

        .modal-content ul {
            list-style: none;
            padding: 0;
        }

        .modal-content ul li {
            margin: 10px 0;
            color: #333;
        }

        .close-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3f51b5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventario de Productos</h1>
        <button type="button" onclick="history.back()">Volver Atrás</button>
        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Producto</th>
                            <th>Nombre Producto</th>
                            <th>Descuento</th>
                            <th>Lote</th>
                            <th>Cantidad Disponible</th>
                            <th>ID Almacén</th>
                            <th>Precio de Compra</th>
                            <th>Precio de Venta</th>
                            <th>Proveedor</th>
                            <th>Categoría</th>
                            <th>Estatus</th>
                            <th>Fecha de Caducidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result->data_seek(0); // Reiniciar el puntero del resultado
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["ID_Prod"] ?? "No disponible" ?></td>
                                <td><?= $row["Nomb_Prod"] ?? "No disponible" ?></td>
                                <td><?= $row["Desc_Prod"] ?? "No disponible" ?></td>
                                <td><?= $row["Lote_Prod"] ?? "No disponible" ?></td>
                                <td><?= $row["Cant_Disp_Prod"] ?? "No disponible" ?></td>
                                <td><?= $row["ID_Almacen"] ?? "No disponible" ?></td>
                                <td><?= $row["Prec_Comp"] ?? "No disponible" ?></td>
                                <td><?= $row["Prec_vent"] ?? "No disponible" ?></td>
                                <td><?= $row["Nombre_Prov"] ?? "No disponible" ?></td>
                                <td><?= $row["ID_Categoria"] ?? "No disponible" ?></td>
                                <td><?= $row["Prod_Estatus"] ?? "No disponible" ?></td>
                                <td><?= $row["Fec_Cad"] ?? "No disponible" ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">No hay productos disponibles en el inventario.</div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($alertas)): ?>
        <div class="modal" id="alert-modal">
            <div class="modal-content">
                <h2>Productos Próximos a Caducar</h2>
                <ul>
                    <?php foreach ($alertas as $alerta): ?>
                        <li><?= $alerta ?></li>
                    <?php endforeach; ?>
                </ul>
                <button class="close-btn" onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Mostrar la alerta al cargar la página
        window.onload = function() {
            const modal = document.getElementById('alert-modal');
            if (modal) modal.style.display = 'flex';
        };

        function closeModal() {
            const modal = document.getElementById('alert-modal');
            if (modal) modal.style.display = 'none';
        }
    </script>
</body>
</html>
