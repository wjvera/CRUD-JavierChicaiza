<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "";
$password = "";
$dbname = "crud_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Rutas de la API
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        // Obtener un registro específico
        $id = $_GET["id"];
        $sql = "SELECT * FROM empleados WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(["message" => "Registro no encontrado"]);
        }
    } else {
        // Obtener todos los registros
        $sql = "SELECT * FROM empleados";
        $result = $conn->query($sql);

        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        echo json_encode($rows);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear un nuevo registro
    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = $data["nombre"];
    $edad = $data["edad"];

    $sql = "INSERT INTO empleados (nombre, edad) VALUES ('$nombre', $edad)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Registro creado con éxito"]);
    } else {
        echo json_encode(["message" => "Error al crear el registro: " . $conn->error]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Actualizar un registro existente
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $_GET["id"];
    $nombre = $data["nombre"];
    $edad = $data["edad"];

    $sql = "UPDATE empleados SET nombre = '$nombre', edad = $edad WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Registro actualizado con éxito"]);
    } else {
        echo json_encode(["message" => "Error al actualizar el registro: " . $conn->error]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Borrar un registro
    $id = $_GET["id"];
    $sql = "DELETE FROM empleados WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Registro borrado con éxito"]);
    } else {
        echo json_encode(["message" => "Error al borrar el registro: " . $conn->error]);
    }
}

$conn->close();
?>
