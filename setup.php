<?php
session_start();
require_once __DIR__ . '/config/database.php';

$count = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='owner'")->fetchColumn();
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $count === 0) {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Completa los datos y utiliza una contraseña de mínimo 8 caracteres.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (business_id,name,email,password_hash,role) VALUES (1,?,?,?,'owner')");
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        $success = true;
    }
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Configurar propietario</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-page"><div class="auth-card">
<a class="brand" href="index.php">BARBER<span>HOUSE</span></a><h1>Crear cuenta del dueño</h1>
<?php if ($success): ?><div class="notice">Cuenta creada. Ya puedes iniciar sesión. Por seguridad, elimina el archivo setup.php del proyecto.</div><a class="button full" href="login.php">Ir al login</a>
<?php elseif ($count > 0): ?><div class="notice">Ya existe una cuenta de dueño. Esta configuración está deshabilitada.</div><a href="login.php">Iniciar sesión</a>
<?php else: ?>
<p class="muted">Este formulario solo funciona una vez para crear al propietario de BarberHouse.</p>
<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><label>Nombre completo</label><input name="name" required>
<label>Correo electrónico</label><input type="email" name="email" required>
<label>Contraseña (mínimo 8 caracteres)</label><input type="password" name="password" minlength="8" required>
<button class="button full">Crear dueño</button></form>
<?php endif; ?></div></body></html>
