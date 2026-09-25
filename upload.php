<?php
require "config.php";
requireLogin();

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_FILES["file"])) {
        $error = "No file selected.";
    } else {

        $file = $_FILES["file"];

        if ($file["error"] !== UPLOAD_ERR_OK) {
            $error = "Upload failed.";
        } elseif ($file["size"] > MAX_FILE_SIZE) {
            $error = "Maximum file size is 10 MB.";
        } else {

            $original = basename($file["name"]);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));

            if (!isset($allowedTypes[$ext])) {
                $error = "This file type is not allowed.";
            } else {

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($file["tmp_name"]);

                if ($mime !== $allowedTypes[$ext]) {
                    $error = "Invalid file type.";
                } else {

                    $stored = bin2hex(random_bytes(16)) . "." . $ext;
                    $destination = UPLOAD_DIR . $stored;

                    if (move_uploaded_file(
                        $file["tmp_name"],
                        $destination
                    )) {

                        $stmt = $pdo->prepare(
                            "INSERT INTO files
                            (user_id,original_name,stored_name,mime_type,size)
                            VALUES (?,?,?,?,?)"
                        );

                        $stmt->execute([
                            $_SESSION["user_id"],
                            $original,
                            $stored,
                            $mime,
                            $file["size"]
                        ]);

                        $message = "File uploaded successfully.";

                    } else {
                        $error = "Could not save file.";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Upload</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<nav>
    <div class="logo">FILE<span>MANAGER</span></div>
    <a href="dashboard.php">Dashboard</a>
</nav>

<main class="container">

    <div class="card upload-card">

        <h1>UPLOAD FILE</h1>

        <?php if ($message): ?>
            <div class="success"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <input
                type="file"
                name="file"
                required
            >

            <p>Maximum size: 10 MB</p>

            <button type="submit">
                UPLOAD
            </button>

        </form>

    </div>

</main>

</body>
</html>
