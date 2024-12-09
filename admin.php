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
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('jejeje.jpg') no-repeat center center fixed;
            background-size: cover; 
            color: #333;
        }
        header {
            background-color: rgba(0, 123, 255); 
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background: #ffffff;
            border-right: 1px solid #ccc;
            padding: 20px;
            height: calc(100vh - 88px); 
        }
        .sidebar h3 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
        }
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            background: rgba(255, 255, 255, 0.9); 
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin-top: 0;
        }
        .actions {
            margin-top: 15px;
        }
        .actions button {
            padding: 10px 15px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: #ffffff;
            cursor: pointer;
        }
        .actions button:hover {
            background: #0056b3;
        }
    </style>
    
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
                <a href="http://localhost/inventario/usario.php">Usuarios</a>
                <a href="http://localhost/inventario/inven.php">Inventarios</a>
                <a href="http://localhost/inventario/prove.php">Proveedores</a>
                <a href="http://localhost/inventario/index.php">Cerrar Sesión</a>
            </div>
        </nav>
    </header>
        <main class="main-content">
            <div class="card">
                <h2>Usuarios</h2>
                <p>Desde aquí puedes gestionar los usuarios del sistema.</p>
                <div class="actions">
                    <form action="http://localhost/inventario/usarmov.php" method="GET" >
                        <button type="submit">
                            Acceder
                        </button>
                    </form>
                </div>
            </div>
            <div class="card">
                <h2>Inventarios</h2>
                <p>Consultar el estado del inventario.</p>
                <div class="actions">
                    <form action="http://localhost/inventario/inven.php" method="GET" >
                        <button type="submit">
                            Acceder
                        </button>
                    </form>
                </div>
            </div>
            <div class="card">
                <h2>Proveedores</h2>
                <p>Consultar la lista de Proveedores.</p>
                <div class="actions">
                    <form action="http://localhost/inventario/prove.php" method="GET" >
                        <button type="submit">
                            Acceder
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>


<?php
    // Cerrar la conexión
    $conn->close();
    ?>

</body>
</html>