<?php
require "../config.php";
requireAdmin();

$users = $pdo
    ->query(
        "SELECT id,username,email,role,created_at
         FROM users
         ORDER BY id DESC"
    )
    ->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Users</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<nav>
    <div class="logo">USER<span>MANAGER</span></div>
    <a href="index.php">Admin</a>
</nav>

<main class="container">

    <h1>USERS</h1>

    <div class="file-list">

        <?php foreach ($users as $user): ?>

            <div class="file">

                <div>
                    <strong>
                        <?= e($user["username"]) ?>
                    </strong>

                    <small>
                        <?= e($user["email"]) ?>
                    </small>
                </div>

                <span class="badge">
                    <?= e($user["role"]) ?>
                </span>

            </div>

        <?php endforeach; ?>

    </div>

</main>

</body>
</html>
