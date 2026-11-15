<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('owner');
require_once __DIR__ . '/../config/database.php';
$barbers = $pdo->query("SELECT u.id,u.name,u.email,u.phone,u.status,bp.specialty FROM users u LEFT JOIN barber_profiles bp ON bp.user_id=u.id WHERE u.role='barber' ORDER BY u.created_at DESC")->fetchAll();
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Barberos</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header class="topbar"><a class="brand" href="../index.php">BARBER<span>HOUSE</span></a><nav><a href="dashboard.php">Panel</a><a href="../logout.php">Salir</a></nav></header>
<main class="dashboard"><div class="page-heading"><div><p class="eyebrow">EQUIPO</p><h1>Barberos</h1></div><a class="button" href="crear-barbero.php">+ Crear barbero</a></div>
<div class="table-wrap"><table><thead><tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Especialidad</th><th>Estado</th></tr></thead><tbody>
<?php foreach ($barbers as $b): ?><tr><td><?= htmlspecialchars($b['name']) ?></td><td><?= htmlspecialchars($b['email']) ?></td><td><?= htmlspecialchars($b['phone'] ?? '') ?></td><td><?= htmlspecialchars($b['specialty'] ?? '—') ?></td><td><?= $b['status']==='active'?'Activo':'Inactivo' ?></td></tr><?php endforeach; ?>
<?php if (!$barbers): ?><tr><td colspan="5">Todavía no hay barberos registrados.</td></tr><?php endif; ?>
</tbody></table></div></main></body></html>
