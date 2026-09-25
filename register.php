<?php
require "config.php";

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (strlen($username) < 3) {
        $error = "Username must contain at least 3 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must contain at least 6 characters.";
    } else {

        $check = $pdo->prepare(
            "SELECT id FROM users WHERE username = ? OR email = ?"
        );
        $check->execute([$username, $email]);

        if ($check->fetch()) {
            $error = "Username or email already exists.";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (username,email,password) VALUES (?,?,?)"
            );

            $stmt->execute([
                $username,
                $email,
                $hash
            ]);

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="auth-box">

    <h1>FILE<span>MANAGER</span></h1>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <?php if ($error): ?>
            <div class="error"><?= e($error) ?></div>
        <?php endif; ?>

        <button type="submit">CREATE ACCOUNT</button>

    </form>

    <p>
        Already registered?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>
