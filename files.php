<?php
require "config.php";
requireLogin();

$stmt = $pdo->prepare(
    "SELECT * FROM files
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->execute([$_SESSION["user_id"]]);

$files = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Files</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<nav>
    <div class="logo">FILE<span>MANAGER</span></div>
    <a href="dashboard.php">Dashboard</a>
</nav>

<main class="container">

    <h1>MY FILES</h1>

    <div class="file-list">

        <?php foreach ($files as $file): ?>

            <div class="file">

                <div>
                    <strong>
                        <?= e($file["original_name"]) ?>
                    </strong>

                    <small>
                        <?= number_format($file["size"] / 1024, 2) ?> KB
                    </small>
                </div>

                <div class="file-actions">

                    <a
                        class="btn"
                        href="download.php?id=<?= (int)$file["id"] ?>"
                    >
                        Download
                    </a>

                    <a
                        class="btn danger"
                        href="delete.php?id=<?= (int)$file["id"] ?>"
                        onclick="return confirm('Delete this file?')"
                    >
                        Delete
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

        <?php if (!$files): ?>
            <div class="card">
                No files uploaded yet.
            </div>
        <?php endif; ?>

    </div>

</main>

</body>
</html>
