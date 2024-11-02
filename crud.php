<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Incluir la conexión a la base de datos
include 'conexion.php';

// Operación: Crear un nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            $nombre = $_POST['product-name'];
            $descripcion = $_POST['product-description'];
            $precio = $_POST['product-price'];

            $sql = "INSERT INTO productos (Nombre, Descripcion, Precio) VALUES ('$nombre', '$descripcion', $precio)";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Producto creado exitosamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al crear producto: " . $conn->error]);
            }
            break;

        case 'read':
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            echo json_encode($productos);
            break;

        case 'update':
            $id = $_POST['product-id'];
            $nombre = $_POST['product-name'];
            $descripcion = $_POST['product-description'];
            $precio = $_POST['product-price'];

            $sql = "UPDATE productos SET Nombre='$nombre', Descripcion='$descripcion', Precio=$precio WHERE ID_producto=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Producto actualizado exitosamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar producto: " . $conn->error]);
            }
            break;

        case 'delete':
            $id = $_POST['product-id'];
            $sql = "DELETE FROM productos WHERE ID_producto=$id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Producto eliminado exitosamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al eliminar producto: " . $conn->error]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Acción no válida"]);
            break;
    }
}


// Cerrar la conexión
$conn->close();
?>
