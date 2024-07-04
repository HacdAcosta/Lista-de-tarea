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

// Procesar formulario de editar notas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno = $_POST["id_alumno"];
    $id_materia = $_POST["id_materia"];
    $nota_lapso1 = $_POST["nota_lapso1"];
    $nota_lapso2 = $_POST["nota_lapso2"];
    $promedio = ($nota_lapso1 + $nota_lapso2) / 2;

    $sql = "UPDATE Notas SET nota_lapso1 = $nota_lapso1, nota_lapso2 = $nota_lapso2, promedio = $promedio WHERE id_alumno = $id_alumno AND id_materia = $id_materia";

    if ($conn->query($sql) === TRUE) {
        echo "Notas actualizadas correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener lista de alumnos y materias
$sql = "SELECT a.id_alumno, a.nombre, a.apellido, m.id_materia, m.nombre_materia, n.nota_lapso1, n.nota_lapso2, n.promedio 
        FROM Alumnos a
        JOIN Notas n ON a.id_alumno = n.id_alumno
        JOIN Materias m ON n.id_materia = m.id_materia
        ORDER BY a.id_alumno";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Notas</h1>
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
            <h2>Lista de Notas</h2>
            <table>
                <tr>
                    <th>Alumno</th>
                    <th>Promedio Final</th>
                    <th>Acción</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    $current_alumno = null;
                    $total_promedio = 0;
                    $total_materias = 0;
                    while($row = $result->fetch_assoc()) {
                        if ($current_alumno != $row["id_alumno"]) {
                            if ($current_alumno != null) {
                                $promedio_final = $total_promedio / $total_materias;
                                echo "<tr>";
                                echo "<td><a href='ver_materias.php?id_alumno=" . $current_alumno . "'>". $nombre . " " . $apellido . "</a></td>";
                                echo "<td>" . number_format($promedio_final, 2) . "</td>";
                                echo "<td><a href='ver_materias.php?id_alumno=" . $current_alumno . "'>Ver Materias</a></td>";
                                echo "</tr>";
                            }
                            $current_alumno = $row["id_alumno"];
                            $nombre = $row["nombre"];
                            $apellido = $row["apellido"];
                            $total_promedio = 0;
                            $total_materias = 0;
                        }
                        $total_promedio += $row["promedio"];
                        $total_materias++;
                    }
                    $promedio_final = $total_promedio / $total_materias;
                    echo "<tr>";
                    echo "<td><a href='ver_materias.php?id_alumno=" . $current_alumno . "'>". $nombre . " " . $apellido . "</a></td>";
                    echo "<td>" . number_format($promedio_final, 2) . "</td>";
                    echo "<td><a href='ver_materias.php?id_alumno=" . $current_alumno . "'>Ver Materias</a></td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='3'>No hay notas registradas.</td></tr>";
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
