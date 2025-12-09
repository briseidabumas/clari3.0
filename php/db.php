<?php
// php/db.php
$host = 'localhost';
$db   = 'clari';
$user = 'root';
$pass = ''; // Por defecto en XAMPP es vacío
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Si falla la conexión, mostramos error JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error de conexión a Base de Datos: ' . $e->getMessage()]);
    exit;
}
?>
