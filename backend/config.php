<?php


$host = getenv('DB_HOST') ?: '3h6pe1.h.filess.io';
$port = getenv('DB_PORT') ?: '3307';
$db = getenv('DB_NAME') ?: 'elvistrofia_youthwrote';
$user = getenv('DB_USER') ?: 'elvistrofia_youthwrote';
$pass = getenv('DB_PASS') ?: '32aedce810e8a0c64feaea6e515b520b14b38fff';

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Error de conexión a la base de datos: ' . $e->getMessage());
}
