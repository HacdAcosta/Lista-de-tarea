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

// Obtener el id_alumno desde la URL
$id_alumno = $_GET["id_alumno"];

// Obtener las materias y notas del alumno
$sql = "SELECT m.nombre_materia, n.nota_lapso1, n.nota_lapso2, n.promedio
        FROM Notas n
        JOIN Materias m ON n.id_materia = m.id_materia
        WHERE n.id_alumno = $id_alumno
        ORDER BY m.nombre_materia";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Materias y Notas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Materias y Notas</h1>
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
            <h2>Materias y Notas del Alumno</h2>
            <table>
                <tr>
                    <th>Materia</th>
                    <th>Nota Lapso 1</th>
                    <th>Nota Lapso 2</th>
                    <th>Promedio</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombre_materia"] . "</td>";
                        echo "<td>" . $row["nota_lapso1"] . "</td>";
                        echo "<td>" . $row["nota_lapso2"] . "</td>";
                        echo "<td>" . $row["promedio"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay notas registradas para este alumno.</td></tr>";
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
