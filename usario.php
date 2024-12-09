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

// Consulta para obtener los usuarios
$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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
            align-items: center;
            height: 100vh;
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px;
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
            margin-top: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        <button type="button" onclick="history.back()">Volver Atrás</button>
        <?php
        // Verificar si hay resultados y mostrarlos
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>Nombre Usuario</th>
                            <th>Rol</th>
                            <th>Email</th>
                            <th>Contraseña</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID_Usuario"] . "</td>
                        <td>" . $row["Nombre_Usuario"] . "</td>
                        <td>" . $row["Rol"] . "</td>
                        <td>" . $row["Email"] . "</td>
                        <td>" . $row["Contraseña"] . "</td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='no-results'>No hay usuarios registrados.</div>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
