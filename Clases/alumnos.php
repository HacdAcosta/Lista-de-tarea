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

// Procesar formulario de agregar alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];

    $sql = "INSERT INTO Alumnos (nombre, apellido, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$fecha_nacimiento')";

    if ($conn->query($sql) === TRUE) {
        echo "Alumno agregado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener lista de alumnos
$sql = "SELECT * FROM Alumnos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumnos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Alumnos</h1>
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
            <h2>Agregar Alumno</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                Fecha de Nacimiento: <input type="date" name="fecha_nacimiento"><br>
                <input type="submit" name="submit" value="Agregar">
            </form>
        </section>

        <section>
            <h2>Lista de Alumnos</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_alumno"]. "</td>";
                        echo "<td>" . $row["nombre"]. "</td>";
                        echo "<td>" . $row["apellido"]. "</td>";
                        echo "<td>" . $row["fecha_nacimiento"]. "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay alumnos registrados.</td></tr>";
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
