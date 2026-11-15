
<?php
session_start();

require_once __DIR__ . '/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 8
    ) {
        $error = 'Revisa los datos. La contraseña debe tener al menos 8 caracteres.';

    } else {

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users
                (business_id, name, email, phone, password_hash, role)
                VALUES (1, ?, ?, ?, ?, 'client')"
            );

            $stmt->execute([
                $name,
                $email,
                $phone,
                password_hash($password, PASSWORD_DEFAULT)
            ]);

            header('Location: login.php?registered=1');
            exit;

        } catch (PDOException $e) {

            error_log('Error al registrar usuario: ' . $e->getMessage());

            if (
                $e->getCode() === '23000' &&
                isset($e->errorInfo[1]) &&
                (int) $e->errorInfo[1] === 1062
            ) {
                $error = 'Ese correo ya está registrado.';
            } else {
                $error = 'No se pudo crear la cuenta. Revisa los registros del servidor.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <a class="brand" href="index.php">
            BARBER<span>HOUSE</span>
        </a>

        <h1>Crear cuenta</h1>

        <p class="muted">
            Regístrate para solicitar tus citas.
        </p>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>Nombre completo</label>
            <input type="text" name="name" required>

            <label>Correo electrónico</label>
            <input type="email" name="email" required>

            <label>Teléfono</label>
            <input type="text" name="phone">

            <label>Contraseña (mínimo 8 caracteres)</label>
            <input
                type="password"
                name="password"
                minlength="8"
                required
            >

            <button type="submit" class="button full">
                Crear cuenta
            </button>

        </form>

        <p class="small">
            ¿Ya tienes cuenta?
            <a href="login.php">Inicia sesión</a>
        </p>

    </div>

</body>
</html>
