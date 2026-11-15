<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('owner');
require_once __DIR__ . '/../config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Completa los campos y utiliza una contraseña de mínimo 8 caracteres.';
    } else {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO users (business_id,name,email,phone,password_hash,role) VALUES (?,?,?,?,?,'barber')");
            $stmt->execute([$_SESSION['user']['business_id'], $name, $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);
            $userId = (int)$pdo->lastInsertId();
            $profile = $pdo->prepare("INSERT INTO barber_profiles (user_id,specialty) VALUES (?,?)");
            $profile->execute([$userId, $specialty]);
            $pdo->commit();
            header('Location: barberos.php?created=1'); exit;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $error = 'No se pudo crear la cuenta. Comprueba que el correo no esté registrado.';
        }
    }
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Crear barbero</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="barberos.php">Volver a barberos</a><a href="../logout.php">Salir</a></nav></header>
<main class="auth-page"><div class="auth-card wide"><p class="eyebrow">NUEVO INTEGRANTE</p><h1>Crear cuenta de barbero</h1><?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><label>Nombre completo</label><input name="name" required><label>Correo electrónico</label><input type="email" name="email" required><label>Teléfono</label><input name="phone"><label>Especialidad</label><input name="specialty" placeholder="Ej. Fade, barba, cortes clásicos"><label>Contraseña inicial</label><input type="password" name="password" minlength="8" required><button class="button full">Crear cuenta</button></form></div></main></body></html>
