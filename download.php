<?php
require "config.php";
requireLogin();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(400);
    exit("Invalid file.");
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
    http_response_code(404);
    exit("File not found.");
}

$path = UPLOAD_DIR . $file["stored_name"];

if (!is_file($path)) {
    http_response_code(404);
    exit("Physical file not found.");
}

header("Content-Type: " . $file["mime_type"]);
header(
    'Content-Disposition: attachment; filename="' .
    basename($file["original_name"]) . '"'
);
header("Content-Length: " . filesize($path));

readfile($path);
exit;
