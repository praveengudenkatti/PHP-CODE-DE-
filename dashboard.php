<?php
require "config.php";
requireLogin();

$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM files WHERE user_id = ?"
);

$stmt->execute([$_SESSION["user_id"]]);

$totalFiles = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<nav>
    <div class="logo">FILE<span>MANAGER</span></div>

    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="files.php">Files</a>
        <a href="upload.php">Upload</a>

        <?php if (isAdmin()): ?>
            <a href="admin/index.php">Admin</a>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>
</nav>

<main class="container">

    <div class="hero">
        <h1>Welcome, <?= e($_SESSION["username"]) ?></h1>
        <p>Your secure personal file manager.</p>
    </div>

    <div class="grid">

        <div class="card">
            <h3>YOUR FILES</h3>
            <strong><?= (int)$totalFiles ?></strong>
        </div>

        <div class="card">
            <h3>ACCOUNT</h3>
            <strong><?= e($_SESSION["role"]) ?></strong>
        </div>

    </div>

    <div class="actions">

        <a class="btn" href="upload.php">
            + Upload File
        </a>

        <a class="btn secondary" href="files.php">
            View Files
        </a>

    </div>

</main>

</body>
</html>
