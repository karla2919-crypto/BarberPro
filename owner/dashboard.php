<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('owner');
require_once __DIR__ . '/../config/database.php';
$totalBarbers = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='barber' AND status='active'")->fetchColumn();
$totalClients = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='client'")->fetchColumn();
$totalAppointments = (int)$pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Panel del dueño</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="../index.php">Ver sitio</a><a href="../logout.php">Cerrar sesión</a></nav></header>
<main class="dashboard"><p class="eyebrow">PANEL DE ADMINISTRACIÓN</p><h1>Hola, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1><p class="muted">Gestiona tu barbería desde aquí.</p>
<div class="stats"><div class="stat"><span>Barberos activos</span><strong><?= $totalBarbers ?></strong></div><div class="stat"><span>Clientes registrados</span><strong><?= $totalClients ?></strong></div><div class="stat"><span>Reservas</span><strong><?= $totalAppointments ?></strong></div></div>
<div class="cards"><a class="card card-link" href="barberos.php"><h3>Gestionar barberos</h3><p>Crear y administrar cuentas del equipo.</p></a><div class="card"><h3>Servicios</h3><p>La gestión de servicios se añadirá en el siguiente módulo.</p></div><div class="card"><h3>Reservas</h3><p>La gestión de citas se añadirá en el siguiente módulo.</p></div></div>
</main></body></html>
