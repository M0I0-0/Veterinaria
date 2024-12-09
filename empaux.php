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
    <title>Panel de Empleados Auxiliares</title>
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
            padding: 20px;
        }
        .section-title {
            font-size: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco */
            display: inline-block; /* Ajusta el tamaño al texto */
            padding: 5px 10px; /* Espaciado interno para mayor visibilidad */
            border-radius: 4px; /* Esquinas redondeadas */
        }
        .card {
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco con transparencia */
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }
        .card p {
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Empleados Auxiliares</h1>
        <nav>
            <a href="http://localhost/inventario/inven.php">Inventario</a>
            <a href="http://localhost/inventario/index.php">Cerrar Sesión</a>
        </nav>
    </header>
    <div class="container">
        <section id="inventario">
            <h2 class="section-title">Inventario</h2>
            <div class="card">
                <h3>Visualizar Inventario</h3>
                <p>Consultar el inventario.</p>
                <a href="http://localhost/inventario/inven.php" class="btn">Acceder</a>
            </div>
        </section>
        <section id="Proveedores">
            <h2 class="section-title">Proveedores</h2>
            <div class="card">
                <h3>Visualizar Proveedores</h3>
                <p> Consultar la lista de Proveedores.</p>
                <a href="http://localhost/inventario/prove.php" class="btn">Acceder</a>
            </div>
        </section>
    </div>

<?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>