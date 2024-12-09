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

// Agregar proveedor
if (isset($_POST['agregar'])) {
    $nombreProveedor = $_POST['nombreProveedor'];
    $telefonoProveedor = $_POST['telefonoProveedor'];
    $direccionProveedor = $_POST['direccionProveedor'];
    $tipoProveedor = $_POST['tipoProveedor'];
    $manejoCambio = $_POST['manejoCambio'];

    if (!empty($nombreProveedor) && !empty($telefonoProveedor) && !empty($direccionProveedor)) {
        $stmt = $conn->prepare("INSERT INTO proveedor (Nomb_Prov, Telefono_Prov, Direccion_Prov, Tipo_Prov, Manejo_Camb) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombreProveedor, $telefonoProveedor, $direccionProveedor, $tipoProveedor, $manejoCambio);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Proveedor agregado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al agregar proveedor: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Actualizar proveedor
if (isset($_POST['actualizar'])) {
    $nombreProveedor = $_POST['nombreProveedor'];
    $telefonoProveedor = $_POST['telefonoProveedor'];
    $direccionProveedor = $_POST['direccionProveedor'];
    $tipoProveedor = $_POST['tipoProveedor'];
    $manejoCambio = $_POST['manejoCambio'];

    if (!empty($nombreProveedor)) {
        $stmt = $conn->prepare("UPDATE proveedor SET Telefono_Prov = ?, Direccion_Prov = ?, Tipo_Prov = ?, Manejo_Camb = ? WHERE Nomb_Prov = ?");
        $stmt->bind_param("sssss", $telefonoProveedor, $direccionProveedor, $tipoProveedor, $manejoCambio, $nombreProveedor);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Proveedor actualizado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al actualizar proveedor: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Eliminar proveedor
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['nombre'])) {
    $nombreProveedor = $_GET['nombre'];

    // Eliminar por nombre
    if (!empty($nombreProveedor)) {
        $stmt = $conn->prepare("DELETE FROM proveedor WHERE Nomb_Prov = ?");
        $stmt->bind_param("s", $nombreProveedor); // Usar "s" para texto
        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Proveedor eliminado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al eliminar proveedor: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Consulta para obtener los proveedores
$sql = "SELECT * FROM proveedor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
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
            align-items: flex-start; /* Comienza desde la parte superior */
            min-height: 100vh;
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto; /* Espaciado alrededor del contenedor */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #3f51b5;
            font-size: 2.5rem;
            margin-top: 20px; /* Espacio superior */
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
            font-size: 1rem;
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
            padding: 8px 12px;
            color: white;
            background-color: #f44336;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-agregar {
            background-color: #4CAF50;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            font-weight: 500;
            margin: 10px 0 5px;
        }

        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Proveedores</h1>
        <button type="button" onclick="history.back()">Volver Atrás</button>
        <!-- Formulario para agregar o actualizar proveedor -->
        <form method="POST" action="">
            <h2>Agregar o Actualizar Proveedor</h2>
            <label for="nombreProveedor">Nombre Proveedor:</label>
            <input type="text" name="nombreProveedor" required><br>

            <label for="telefonoProveedor">Teléfono:</label>
            <input type="text" name="telefonoProveedor" required><br>

            <label for="direccionProveedor">Dirección:</label>
            <input type="text" name="direccionProveedor" required><br>

            <label for="tipoProveedor">Tipo de Proveedor:</label>
            <input type="text" name="tipoProveedor" required><br>

            <label for="manejoCambio">Manejo Cambio:</label>
            <input type="text" name="manejoCambio" required><br>

            <button type="submit" name="agregar" class="btn btn-agregar">Agregar Proveedor</button>
            <button type="submit" name="actualizar" class="btn">Actualizar Proveedor</button>
        </form>

        <?php
        // Verificar si hay resultados y mostrarlos
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Nombre Proveedor</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Tipo de proveedor</th>
                            <th>Maneja cambio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["Nomb_Prov"] . "</td>
                        <td>" . $row["Telefono_Prov"] . "</td>
                        <td>" . $row["Direccion_Prov"] . "</td>
                        <td>" . $row["Tipo_Prov"] . "</td>
                        <td>" . $row["Manejo_Camb"] . "</td>
                        <td>
                            <a href='?accion=eliminar&nombre=" . urlencode($row["Nomb_Prov"]) . "' class='btn'>Eliminar</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='no-results'>No hay proveedores registrados.</div>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
