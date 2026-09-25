<?php
require "../config.php";
requireAdmin();

$totalUsers = $pdo
    ->query("SELECT COUNT(*) FROM users")
    ->fetchColumn();

$totalFiles = $pdo
    ->query("SELECT COUNT(*) FROM files")
    ->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<nav>
    <div class="logo">ADMIN<span>PANEL</span></div>
    <a href="../dashboard.php">Dashboard</a>
</nav>

<main class="container">

    <h1>ADMIN DASHBOARD</h1>

    <div class="grid">

        <div class="card">
            <h3>TOTAL USERS</h3>
            <strong><?= (int)$totalUsers ?></strong>
        </div>

        <div class="card">
            <h3>TOTAL FILES</h3>
            <strong><?= (int)$totalFiles ?></strong>
        </div>

    </div>

    <br>

    <a class="btn" href="users.php">
        Manage Users
    </a>

</main>

</body>
</html>
