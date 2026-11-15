<?php
session_start();
if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
$role = $_SESSION['user']['role'];
if ($role === 'owner') { header('Location: owner/dashboard.php'); exit; }
if ($role === 'barber') { header('Location: barber/dashboard.php'); exit; }
header('Location: client/dashboard.php'); exit;
