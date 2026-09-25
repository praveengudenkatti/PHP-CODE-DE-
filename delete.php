<?php
require "config.php";
requireLogin();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid request.");
}

$stmt = $pdo->prepare(
    "SELECT * FROM files
     WHERE id = ? AND user_id = ?"
);

$stmt->execute([
    $id,
    $_SESSION["user_id"]
]);

$file = $stmt->fetch();

if (!$file) {
    exit("File not found.");
}

$path = UPLOAD_DIR . $file["stored_name"];

if (is_file($path)) {
    unlink($path);
}

$stmt = $pdo->prepare(
    "DELETE FROM files WHERE id = ?"
);

$stmt->execute([$id]);

header("Location: files.php");
exit;
