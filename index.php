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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('fondo.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container img {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo.jpg" alt="Logo">
        <h1>Iniciar Sesión</h1>
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Ingresar</button>
            </div>
        </form>
    </div>

    <script>
        // Script para manejar el inicio de sesión y redirección
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío predeterminado del formulario

            // Obtener el valor ingresado en el campo de usuario
            const username = document.getElementById('username').value.toLowerCase();

            // Validar el tipo de usuario y redirigir a la interfaz correspondiente
            if (username === 'admin') {
                window.location.href = 'http://localhost/inventario/admin.php'; // Redirige a la interfaz de administrador
            } else if (username === 'gerente') {
                window.location.href = 'http://localhost/inventario/gerente.php'; // Redirige a la interfaz de gerente
            } else if (username === 'bodega') {
                window.location.href = 'http://localhost/inventario/bodega.php'; // Redirige a la interfaz de bodega
            } else if (username === 'auxiliar') {
                window.location.href = 'http://localhost/inventario/empaux.php'; // Redirige a la interfaz de auxiliar
            } else {
                alert('Usuario no reconocido. Por favor, verifica tus credenciales.');
            }
        });
    </script>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>
