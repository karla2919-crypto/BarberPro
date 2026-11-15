<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('barber');
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Panel del barbero</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="../logout.php">Cerrar sesión</a></nav></header><main class="dashboard"><p class="eyebrow">PANEL DEL BARBERO</p><h1>Hola, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1><p class="muted">Tu agenda y solicitudes de citas estarán disponibles aquí.</p><div class="card"><h3>Agenda</h3><p>El módulo de gestión de citas será el siguiente en desarrollarse.</p></div></main></body></html>
