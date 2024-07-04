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

// Procesar formulario de agregar promedio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno = $_POST["id_alumno"];
    $id_materia = $_POST["id_materia"];
    $nota_lapso1 = $_POST["nota_lapso1"];
    $nota_lapso2 = $_POST["nota_lapso2"];
    $promedio = ($nota_lapso1 + $nota_lapso2) / 2;

    $sql = "INSERT INTO Notas (id_alumno, id_materia, nota_lapso1, nota_lapso2, promedio) VALUES ($id_alumno, $id_materia, $nota_lapso1, $nota_lapso2, $promedio)";

    if ($conn->query($sql) === TRUE) {
        echo "Promedio agregado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener lista única de alumnos
$sql_alumnos = "SELECT DISTINCT id_alumno, nombre, apellido FROM Alumnos";
$result_alumnos = $conn->query($sql_alumnos);

// Obtener lista única de materias
$sql_materias = "SELECT DISTINCT id_materia, nombre_materia FROM Materias";
$result_materias = $conn->query($sql_materias);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Promedio</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Agregar Promedio</h1>
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
            <h2>Agregar Promedio</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Alumno: 
                <select name="id_alumno">
                    <?php
                    while($row = $result_alumnos->fetch_assoc()) {
                        echo "<option value='" . $row["id_alumno"] . "'>" . $row["nombre"] . " " . $row["apellido"] . "</option>";
                    }
                    ?>
                </select><br>
                Materia:
                <select name="id_materia">
                    <?php
                    while($row = $result_materias->fetch_assoc()) {
                        echo "<option value='" . $row["id_materia"] . "'>" . $row["nombre_materia"] . "</option>";
                    }
                    ?>
                </select><br>
                Nota Lapso 1: <input type="text" name="nota_lapso1"><br>
                Nota Lapso 2: <input type="text" name="nota_lapso2"><br>
                <input type="submit" name="submit" value="Agregar Promedio">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Sistema de Gestión de Notas Estudiantiles</p>
    </footer>
</body>
</html>
