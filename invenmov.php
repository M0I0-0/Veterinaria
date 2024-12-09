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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'registrar') {
            // Insertar nuevo producto
            $id_prod = $_POST["ID_Prod"];
            $nomb_prod = $_POST["Nomb_Prod"];
            $desc_prod = $_POST["Desc_Prod"];
            $lote_prod = $_POST["Lote_Prod"];
            $cant_disp_prod = $_POST["Cant_Disp_Prod"];
            $id_almacen = $_POST["ID_Almacen"];
            $prec_comp = $_POST["Prec_Comp"];
            $prec_vent = $_POST["Prec_vent"];
            $nombre_prov = $_POST["Nombre_Prov"];
            $id_categoria = $_POST["ID_Categoria"];
            $prod_estatus = $_POST["Prod_Estatus"];
            $fec_cad = $_POST["Fec_Cad"];

            $sql_insert = "INSERT INTO productos (ID_Prod, Nomb_Prod, Desc_Prod, Lote_Prod, Cant_Disp_Prod, ID_Almacen, Prec_Comp, Prec_vent, Nombre_Prov, ID_Categoria, Prod_Estatus, Fec_Cad)
                VALUES ('$id_prod', '$nomb_prod', '$desc_prod', '$lote_prod', '$cant_disp_prod', '$id_almacen', '$prec_comp', '$prec_vent', '$nombre_prov', '$id_categoria', '$prod_estatus', '$fec_cad')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "<p style='color:green; text-align:center;'>Producto agregado exitosamente.</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>Error al agregar producto: " . $conn->error . "</p>";
            }
        } elseif ($_POST['accion'] === 'eliminar') {
            // Eliminar producto
            $id_prod = $_POST['ID_Prod'];
            $sql_delete = "DELETE FROM productos WHERE ID_Prod = '$id_prod'";

            if ($conn->query($sql_delete) === TRUE) {
                echo "<p style='color:green; text-align:center;'>Producto eliminado exitosamente.</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>Error al eliminar producto: " . $conn->error . "</p>";
            }
        } elseif ($_POST['accion'] === 'modificar') {
            // Modificar producto
            $id_prod = $_POST["ID_Prod"];
            $nomb_prod = $_POST["Nomb_Prod"];
            $desc_prod = $_POST["Desc_Prod"];
            $lote_prod = $_POST["Lote_Prod"];
            $cant_disp_prod = $_POST["Cant_Disp_Prod"];
            $id_almacen = $_POST["ID_Almacen"];
            $prec_comp = $_POST["Prec_Comp"];
            $prec_vent = $_POST["Prec_vent"];
            $nombre_prov = $_POST["Nombre_Prov"];
            $id_categoria = $_POST["ID_Categoria"];
            $prod_estatus = $_POST["Prod_Estatus"];
            $fec_cad = $_POST["Fec_Cad"];

            $sql_update = "UPDATE productos SET 
                Nomb_Prod='$nomb_prod',
                Desc_Prod='$desc_prod',
                Lote_Prod='$lote_prod',
                Cant_Disp_Prod='$cant_disp_prod',
                ID_Almacen='$id_almacen',
                Prec_Comp='$prec_comp',
                Prec_vent='$prec_vent',
                Nombre_Prov='$nombre_prov',
                ID_Categoria='$id_categoria',
                Prod_Estatus='$prod_estatus',
                Fec_Cad='$fec_cad'
                WHERE ID_Prod='$id_prod'";

            if ($conn->query($sql_update) === TRUE) {
                echo "<p style='color:green; text-align:center;'>Producto actualizado exitosamente.</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>Error al actualizar producto: " . $conn->error . "</p>";
            }
        }
    }
}

// Consultar los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Si se solicita modificar un producto, obtener sus datos
$product = null;
if (isset($_GET['ID_Prod'])) {
    $id_prod = $_GET['ID_Prod'];
    $sql_product = "SELECT * FROM productos WHERE ID_Prod = '$id_prod'";
    $product_result = $conn->query($sql_product);
    $product = $product_result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        color: #333;
    }

    .container {
        max-width: 1500px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h1 {
        text-align: center;
        color: #007BFF;
        font-size: 2rem;
    }

    form {
        margin: 20px 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    form input, form button {
        margin: 5px;
        padding: 10px;
        font-size: 1rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        width: calc(30% - 10px);
        box-sizing: border-box;
    }

    form input:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    form button {
        background-color: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    form button:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f7fc;
        color: #333;
        text-align: center;
    }

    td {
        text-align: center;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    button {
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        form input, form button {
            width: calc(45% - 10px);
        }
    }

    @media (max-width: 480px) {
        form input, form button {
            width: 100%;
        }

        th, td {
            font-size: 0.9rem;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Inventario de Productos</h1>

        <!-- Formulario de registro -->
        <form method="post">
            <input type="hidden" name="accion" value="registrar">
            <input type="text" name="ID_Prod" placeholder="ID Producto" required>
            <input type="text" name="Nomb_Prod" placeholder="Nombre Producto" required>
            <input type="text" name="Desc_Prod" placeholder="Descripción">
            <input type="text" name="Lote_Prod" placeholder="Lote">
            <input type="number" name="Cant_Disp_Prod" placeholder="Cantidad Disponible">
            <input type="text" name="ID_Almacen" placeholder="ID Almacén">
            <input type="number" step="0.01" name="Prec_Comp" placeholder="Precio de Compra">
            <input type="number" step="0.01" name="Prec_vent" placeholder="Precio de Venta">
            <input type="text" name="Nombre_Prov" placeholder="Proveedor">
            <input type="text" name="ID_Categoria" placeholder="Categoría">
            <input type="text" name="Prod_Estatus" placeholder="Estatus">
            <input type="date" name="Fec_Cad" placeholder="Fecha de Caducidad">
            <button type="submit">Registrar Producto</button>
        </form>
        <button type="button" onclick="history.back()">Volver Atrás</button>


        <?php if ($product): ?>
        <!-- Formulario de modificación -->
        <h2>Modificar Producto</h2>
        <form method="post">
            <input type="hidden" name="accion" value="modificar">
            <input type="hidden" name="ID_Prod" value="<?= $product['ID_Prod'] ?>">
            <input type="text" name="Nomb_Prod" value="<?= $product['Nomb_Prod'] ?>" required>
            <input type="text" name="Desc_Prod" value="<?= $product['Desc_Prod'] ?>">
            <input type="text" name="Lote_Prod" value="<?= $product['Lote_Prod'] ?>">
            <input type="number" name="Cant_Disp_Prod" value="<?= $product['Cant_Disp_Prod'] ?>" required>
            <input type="text" name="ID_Almacen" value="<?= $product['ID_Almacen'] ?>">
            <input type="number" step="0.01" name="Prec_Comp" value="<?= $product['Prec_Comp'] ?>" required>
            <input type="number" step="0.01" name="Prec_vent" value="<?= $product['Prec_vent'] ?>" required>
            <input type="text" name="Nombre_Prov" value="<?= $product['Nombre_Prov'] ?>" required>
            <input type="text" name="ID_Categoria" value="<?= $product['ID_Categoria'] ?>" required>
            <input type="text" name="Prod_Estatus" value="<?= $product['Prod_Estatus'] ?>" required>
            <input type="date" name="Fec_Cad" value="<?= $product['Fec_Cad'] ?>" required>
            <button type="submit">Actualizar Producto</button>
        </form>


        <?php endif; ?>

        <!-- Mostrar productos -->
        <table>
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre Producto</th>
                    <th>Descuento</th>
                    <th>Lote</th>
                    <th>Cantidad Disponible</th>
                    <th>ID Almacén</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Proveedor</th>
                    <th>Categoría</th>
                    <th>Estatus</th>
                    <th>Fecha Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["ID_Prod"] ?></td>
                    <td><?= $row["Nomb_Prod"] ?></td>
                    <td><?= $row["Desc_Prod"] ?></td>
                    <td><?= $row["Lote_Prod"] ?></td>
                    <td><?= $row["Cant_Disp_Prod"] ?></td>
                    <td><?= $row["ID_Almacen"] ?></td>
                    <td><?= $row["Prec_Comp"] ?></td>
                    <td><?= $row["Prec_vent"] ?></td>
                    <td><?= $row["Nombre_Prov"] ?></td>
                    <td><?= $row["ID_Categoria"] ?></td>
                    <td><?= $row["Prod_Estatus"] ?></td>
                    <td><?= $row["Fec_Cad"] ?></td>
                    <td>
                        <form method="get" action="">
                            <input type="hidden" name="ID_Prod" value="<?= $row['ID_Prod'] ?>">
                            <button type="submit">Modificar</button>
                        </form>
                        <form method="post" action="">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="ID_Prod" value="<?= $row['ID_Prod'] ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
