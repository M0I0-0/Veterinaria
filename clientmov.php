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

// Agregar cliente
if (isset($_POST['agregar'])) {
    $idCliente = $_POST['idCliente']; // ID como texto
    $nombreCliente = $_POST['nombreCliente'];
    $direccionCliente = $_POST['direccionCliente'];
    $telefonoCliente = $_POST['telefonoCliente'];

    if (!empty($idCliente) && !empty($nombreCliente) && !empty($direccionCliente) && !empty($telefonoCliente)) {
        $stmt = $conn->prepare("INSERT INTO cliente (ID_Cliente, Nombre_Cliente, Direc_Cliente, Telef_Cliente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $idCliente, $nombreCliente, $direccionCliente, $telefonoCliente);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Cliente agregado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al agregar cliente: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Actualizar cliente
if (isset($_POST['actualizar'])) {
    $idCliente = $_POST['idCliente']; // ID como texto
    $nombreCliente = $_POST['nombreCliente'];
    $direccionCliente = $_POST['direccionCliente'];
    $telefonoCliente = $_POST['telefonoCliente'];

    if (!empty($idCliente)) {
        $stmt = $conn->prepare("UPDATE cliente SET Nombre_Cliente = ?, Direc_Cliente = ?, Telef_Cliente = ? WHERE ID_Cliente = ?");
        $stmt->bind_param("ssss", $nombreCliente, $direccionCliente, $telefonoCliente, $idCliente);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Cliente actualizado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al actualizar cliente: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Eliminar cliente
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $idCliente = $_GET['id']; // ID como texto

    // Eliminar por ID
    if (!empty($idCliente)) {
        $stmt = $conn->prepare("DELETE FROM cliente WHERE ID_Cliente = ?");
        $stmt->bind_param("s", $idCliente); // Usar "s" para cadenas de texto
        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Cliente eliminado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al eliminar cliente: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Consulta para obtener los clientes
$sql = "SELECT * FROM cliente";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
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
        <h1>Gestión de Clientes</h1>
        <button type="button" onclick="history.back()">Volver Atrás</button>
        <!-- Formulario para agregar o actualizar cliente -->
        <form method="POST" action="">
            <h2>Agregar o Actualizar Cliente</h2>

            <!-- Campo para ID del cliente (para actualizar) -->
            <label for="idCliente">ID Cliente (para actualizar):</label>
            <input type="text" name="idCliente" placeholder="Ingrese ID Cliente" ><br>

            <label for="nombreCliente">Nombre:</label>
            <input type="text" name="nombreCliente" required><br>

            <label for="direccionCliente">Dirección:</label>
            <input type="text" name="direccionCliente" required><br>

            <label for="telefonoCliente">Teléfono:</label>
            <input type="text" name="telefonoCliente" required><br>

            <button type="submit" name="agregar" class="btn btn-agregar">Agregar Cliente</button>
            <button type="submit" name="actualizar" class="btn">Actualizar Cliente</button>
        </form>

        <?php
        // Verificar si hay resultados y mostrarlos
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID Cliente</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID_Cliente"] . "</td>
                        <td>" . $row["Nombre_Cliente"] . "</td>
                        <td>" . $row["Direc_Cliente"] . "</td>
                        <td>" . $row["Telef_Cliente"] . "</td>
                        <td>
                            <a href='?accion=eliminar&id=" . $row["ID_Cliente"] . "' class='btn'>Eliminar</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='no-results'>No hay clientes registrados.</div>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
