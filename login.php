
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare(
            "SELECT id, business_id, name, email, password_hash, role, status
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (
            $user &&
            $user['status'] === 'active' &&
            password_verify($password, $user['password_hash'])
        ) {

            session_regenerate_id(true);

            unset($user['password_hash']);

            $_SESSION['user'] = $user;

            header('Location: dashboard.php');
            exit;

        } else {
            $error = 'Correo o contraseña incorrectos, o cuenta inactiva.';
        }

    } catch (PDOException $e) {
        error_log('Error al iniciar sesión: ' . $e->getMessage());
        $error = 'No se pudo iniciar sesión. Intenta nuevamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <a class="brand" href="index.php">
            BARBER<span>HOUSE</span>
        </a>

        <h1>Iniciar sesión</h1>

        <p class="muted">
            Accede a tu cuenta de BarberPro.
        </p>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>Correo electrónico</label>
            <input
                type="email"
                name="email"
                required
                autocomplete="email"
            >

            <label>Contraseña</label>
            <input
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit" class="button full">
                Entrar
            </button>

        </form>

        <p class="small">
            ¿No tienes cuenta?
            <a href="registro.php">Regístrate</a>
        </p>

    </div>

</body>
</html>
