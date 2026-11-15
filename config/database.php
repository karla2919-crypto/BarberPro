
<?php
declare(strict_types=1);

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$port = getenv('DB_PORT') ?: '3306';

if (!$host || !$dbname || !$username || $password === false) {
    http_response_code(500);
    exit('Faltan variables de conexión en Railway.');
}

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

} catch (PDOException $e) {
    error_log('Error MySQL: ' . $e->getMessage());
    http_response_code(500);
    exit('No se pudo conectar con la base de datos de BarberPro.');
}
