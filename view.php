<?php
// Incluir archivo de configuración
require 'config.php';

// Validar parámetro de tabla
$table = isset($_GET['table']) ? $_GET['table'] : '';
if (!in_array($table, ['bienes', 'ubicaciones'])) {
    die('Tabla no válida');
}

// Conexión a la base de datos
$conn = connectDB();

// Consultar datos
$sql = "SELECT * FROM $table ORDER BY id DESC";
$result = $conn->query($sql);

// Título y columnas según la tabla
if ($table === 'bienes') {
    $title = "Lista de Bienes";
    $headers = ['ID', 'Bien', 'Tipo', 'Fecha Registro'];
} else {
    $title = "Lista de Ubicaciones";
    $headers = ['ID', 'Bien', 'Ubicación', 'Fecha Registro'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Sistema de Carga</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        
        <div class="card">
            <div class="button-group">
                <a href="index.html" class="btn btn-primary">Volver al inicio</a>
            </div>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="preview-container">
                    <table>
                        <tr>
                            <?php foreach ($headers as $header): ?>
                                <th><?php echo $header; ?></th>
                            <?php endforeach; ?>
                        </tr>
                        
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['bien']; ?></td>
                                <?php if ($table === 'bienes'): ?>
                                    <td><?php echo $row['tipo']; ?></td>
                                <?php else: ?>
                                    <td><?php echo $row['ubicacion']; ?></td>
                                <?php endif; ?>
                                <td><?php echo $row['fecha_registro']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            <?php else: ?>
                <p>No hay datos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
// Cerrar conexión
$conn->close();
?>
