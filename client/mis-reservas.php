<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('client');
require_once __DIR__ . '/../config/database.php';
$stmt = $pdo->prepare("SELECT a.requested_at,a.status,s.name AS service,b.name AS barber FROM appointments a JOIN services s ON s.id=a.service_id JOIN users b ON b.id=a.barber_id WHERE a.client_id=? ORDER BY a.requested_at DESC");
$stmt->execute([$_SESSION['user']['id']]);
$appointments = $stmt->fetchAll();
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Mis reservas</title><link rel="stylesheet" href="../assets/css/style.css"></head><body><header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="dashboard.php">Mi cuenta</a><a href="../logout.php">Salir</a></nav></header><main class="dashboard"><h1>Mis reservas</h1><div class="table-wrap"><table><thead><tr><th>Servicio</th><th>Barbero</th><th>Fecha solicitada</th><th>Estado</th></tr></thead><tbody><?php foreach($appointments as $a): ?><tr><td><?= htmlspecialchars($a['service']) ?></td><td><?= htmlspecialchars($a['barber']) ?></td><td><?= htmlspecialchars($a['requested_at']) ?></td><td><?= htmlspecialchars($a['status']) ?></td></tr><?php endforeach; ?><?php if(!$appointments): ?><tr><td colspan="4">Todavía no tienes reservas.</td></tr><?php endif; ?></tbody></table></div></main></body></html>
