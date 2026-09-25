<?php
require "config.php";

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $login = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare(
        "SELECT * FROM users
         WHERE username = ? OR email = ?
         LIMIT 1"
    );

    $stmt->execute([$login, $login]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid login details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="auth-box">

    <h1>FILE<span>MANAGER</span></h1>

    <?php if (isset($_GET["registered"])): ?>
        <div class="success">
            Registration successful. Login now.
        </div>
    <?php endif; ?>

    <form method="POST">

        <input
            type="text"
            name="login"
            placeholder="Username / Email"
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

        <button type="submit">LOGIN</button>

    </form>

    <p>
        No account?
        <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>
