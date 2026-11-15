<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('client');
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Mi cuenta</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="../index.php">Servicios</a><a href="mis-reservas.php">Mis reservas</a><a href="../logout.php">Salir</a></nav></header><main class="dashboard"><p class="eyebrow">MI CUENTA</p><h1>Hola, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1><p class="muted">Bienvenido a BarberHouse. Desde aquí podrás gestionar tus citas.</p><a class="button" href="../index.php#servicios">Ver servicios</a></main></body></html>
