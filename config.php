<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sistema_inventario');

// Conexión a la base de datos
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Crear base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la base de datos: " . $conn->error);
    }
    
    // Seleccionar la base de datos
    $conn->select_db(DB_NAME);
    
    // Crear tablas si no existen
    $sqlBienes = "CREATE TABLE IF NOT EXISTS bienes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        bien VARCHAR(255) NOT NULL,
        tipo VARCHAR(50) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $sqlUbicaciones = "CREATE TABLE IF NOT EXISTS ubicaciones (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        bien VARCHAR(255) NOT NULL,
        ubicacion VARCHAR(255) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sqlBienes) === FALSE) {
        die("Error al crear la tabla bienes: " . $conn->error);
    }
    
    if ($conn->query($sqlUbicaciones) === FALSE) {
        die("Error al crear la tabla ubicaciones: " . $conn->error);
    }
    
    return $conn;
}
?>
