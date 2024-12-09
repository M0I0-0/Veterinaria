<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === "Agregar") {
        $ID_Usuario = $_POST["ID_Usuario"];
        $Nombre_Usuario = $_POST["Nombre_Usuario"];
        $Rol = $_POST["Rol"];
        $Email = $_POST["Email"];
        $Contraseña = password_hash($_POST["Contraseña"], PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO usuario (ID_Usuario, Nombre_Usuario, Rol, Email, Contraseña) 
                       VALUES ('$ID_Usuario', '$Nombre_Usuario', '$Rol', '$Email', '$Contraseña')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<p style='color:green; text-align:center;'>Usuario agregado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al agregar usuario: " . $conn->error . "</p>";
        }
    } elseif ($accion === "Actualizar") {
        $ID_Usuario = $_POST["ID_Usuario"];
        $Nombre_Usuario = $_POST["Nombre_Usuario"];
        $Rol = $_POST["Rol"];
        $Email = $_POST["Email"];
        $Contraseña = password_hash($_POST["Contraseña"], PASSWORD_DEFAULT);

        $sql_update = "UPDATE usuario 
                       SET Nombre_Usuario='$Nombre_Usuario', Rol='$Rol', Email='$Email', Contraseña='$Contraseña' 
                       WHERE ID_Usuario='$ID_Usuario'";

        if ($conn->query($sql_update) === TRUE) {
            echo "<p style='color:green; text-align:center;'>Usuario actualizado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al actualizar usuario: " . $conn->error . "</p>";
        }
    } elseif ($accion === "Eliminar") {
        $ID_Usuario = $_POST['ID_Usuario'];

        $stmt = $conn->prepare("DELETE FROM usuario WHERE ID_Usuario = ?");
        $stmt->bind_param("s", $ID_Usuario);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Usuario eliminado exitosamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error al eliminar usuario: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
    /* Estilo general de la página */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7fc; /* Fondo gris claro */
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    h1 {
        margin-top: 20px;
        color: #3f51b5; /* Azul oscuro */
        font-size: 2.5rem;
        text-align: center;
    }

    /* Estilo de la tabla */
    table {
        border-collapse: collapse;
        width: 90%;
        margin: 20px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 1rem;
    }

    th {
        background-color: #3f51b5; /* Azul oscuro */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9; /* Fondo gris claro */
    }

    tr:hover {
        background-color: #f1f1f1; /* Fondo gris más claro */
    }

    /* Estilo de los enlaces de acción */
    a {
        color: white;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        margin: 2px;
    }

    a[href*="eliminar"] {
        background-color: #f44336; /* Rojo */
    }

    a[href*="editar"] {
        background-color: #3f51b5; /* Azul oscuro */
    }

    /* Estilo del formulario */
    .form-container {
        margin: 20px;
        padding: 20px;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
    }

    .form-container input {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-container button {
        width: 48%;
        background-color: #4CAF50; /* Verde */
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-transform: uppercase;
        margin: 2px;
    }

    .form-container button:hover {
        background-color: #45a049; /* Verde más oscuro */
    }

    /* Responsividad */
    @media (max-width: 768px) {
        table {
            font-size: 14px;
        }

        .form-container {
            width: 100%;
            padding: 15px;
        }

        .form-container button {
            width: 100%;
        }
    }
</style>

</head>
<body>
    <h1>Gestión de Usuarios</h1>
    <button type="button" onclick="history.back()">Volver Atrás</button>
    <!-- Formulario de registro/actualización -->
    <div class="form-container">
        <form action="" method="POST">
            <input type="text" name="ID_Usuario" placeholder="ID Usuario" required>
            <input type="text" name="Nombre_Usuario" placeholder="Nombre de Usuario" required>
            <input type="text" name="Rol" placeholder="Rol" required>
            <input type="email" name="Email" placeholder="Correo Electrónico" required>
            <input type="password" name="Contraseña" placeholder="Contraseña" required>
            <button type="submit" name="accion" value="Agregar">Agregar</button>
            <button type="submit" name="accion" value="Actualizar">Actualizar</button>
        </form>
    </div>

    <!-- Tabla de usuarios -->
    <?php
    $sql = "SELECT * FROM usuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre de Usuario</th>
                        <th>Rol</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["ID_Usuario"] . "</td>
                    <td>" . $row["Nombre_Usuario"] . "</td>
                    <td>" . $row["Rol"] . "</td>
                    <td>" . $row["Email"] . "</td>
                    <td>
                        <form action='' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='ID_Usuario' value='" . $row["ID_Usuario"] . "'>
                            <button type='submit' name='accion' value='Eliminar' style='background-color:#f44336; color:white; padding:6px 12px; border:none; border-radius:4px; cursor:pointer;'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay usuarios registrados.</p>";
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>
