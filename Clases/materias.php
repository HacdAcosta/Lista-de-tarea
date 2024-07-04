<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "francisco";
$password = "susana120306";
$dbname = "alumnado";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar formulario de agregar materia
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_materia = $_POST["nombre_materia"];
    $descripcion = $_POST["descripcion"];

    $sql = "INSERT INTO Materias (nombre_materia, descripcion) VALUES ('$nombre_materia', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "Materia agregada correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener lista de materias
$sql = "SELECT * FROM Materias";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Materias</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Materias</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="alumnos.php">Alumnos</a></li>
                <li><a href="materias.php">Materias</a></li>
                <li><a href="notas.php">Notas</a></li>
                <li><a href="agregar_promedio.php">Agregar Promedio</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Agregar Materia</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Nombre de la Materia: <input type="text" name="nombre_materia"><br>
                Descripción: <textarea name="descripcion"></textarea><br>
                <input type="submit" name="submit" value="Agregar">
            </form>
        </section>

        <section>
            <h2>Lista de Materias</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_materia"]. "</td>";
                        echo "<td>" . $row["nombre_materia"]. "</td>";
                        echo "<td>" . $row["descripcion"]. "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay materias registradas.</td></tr>";
                }
                ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Sistema de Gestión de Notas Estudiantiles</p>
    </footer>
</body>
</html>