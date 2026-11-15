<?php
session_start();
require_once __DIR__ . '/config/database.php';
$services = $pdo->query("SELECT name, description, price, duration_minutes FROM services WHERE status='active' ORDER BY name")->fetchAll();
$barbers = $pdo->query("SELECT u.name, bp.specialty FROM users u LEFT JOIN barber_profiles bp ON bp.user_id=u.id WHERE u.role='barber' AND u.status='active' ORDER BY u.name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BarberHouse | BarberPro</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="index.php">BARBER<span>HOUSE</span></a>
  <nav><a href="#servicios">Servicios</a><a href="#barberos">Barberos</a>
  <?php if (!empty($_SESSION['user'])): ?>
    <a href="dashboard.php">Mi panel</a><a href="logout.php">Salir</a>
  <?php else: ?>
    <a href="login.php">Iniciar sesión</a><a class="nav-cta" href="registro.php">Crear cuenta</a>
  <?php endif; ?>
  </nav>
</header>
<main>
<section class="hero">
  <p class="eyebrow">BARBERPRO BETA · BARRERÍA DE PRUEBA</p>
  <h1>Tu estilo.<br><span>Nuestra precisión.</span></h1>
  <p>Bienvenido a BarberHouse. Conoce nuestros servicios y solicita tu próxima cita.</p>
  <a class="button" href="registro.php">Reservar una cita</a>
</section>
<section class="section" id="servicios">
  <div class="section-heading"><p class="eyebrow">LO QUE HACEMOS</p><h2>Servicios y precios</h2></div>
  <div class="cards">
  <?php if (!$services): ?><p class="muted">Próximamente publicaremos nuestros servicios.</p><?php endif; ?>
  <?php foreach ($services as $service): ?>
    <article class="card"><h3><?= htmlspecialchars($service['name']) ?></h3>
      <p><?= htmlspecialchars($service['description'] ?? '') ?></p>
      <div class="card-meta"><strong>$<?= number_format((float)$service['price'], 0, ',', '.') ?></strong><span><?= (int)$service['duration_minutes'] ?> min</span></div>
    </article>
  <?php endforeach; ?>
  </div>
</section>
<section class="section" id="barberos">
  <div class="section-heading"><p class="eyebrow">NUESTRO EQUIPO</p><h2>Barberos</h2></div>
  <div class="cards">
  <?php if (!$barbers): ?><p class="muted">El equipo de BarberHouse aparecerá aquí.</p><?php endif; ?>
  <?php foreach ($barbers as $barber): ?>
    <article class="card"><h3><?= htmlspecialchars($barber['name']) ?></h3><p><?= htmlspecialchars($barber['specialty'] ?? 'Barbero') ?></p></article>
  <?php endforeach; ?>
  </div>
</section>
</main>
<footer>© <?= date('Y') ?> BarberHouse · Desarrollado con BarberPro</footer>
</body></html>
