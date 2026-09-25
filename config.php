<?php
session_start();

$db_host = "localhost";
$db_name = "file_manager";
$db_user = "root";
$db_pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    exit("Database connection failed.");
}

define("UPLOAD_DIR", __DIR__ . "/uploads/");
define("MAX_FILE_SIZE", 10 * 1024 * 1024); // 10 MB

$allowedTypes = [
    "jpg"  => "image/jpeg",
    "jpeg" => "image/jpeg",
    "png"  => "image/png",
    "gif"  => "image/gif",
    "webp" => "image/webp",
    "pdf"  => "application/pdf",
    "txt"  => "text/plain",
    "zip"  => "application/zip",
    "doc"  => "application/msword",
    "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
];

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
}

function requireAdmin() {
    requireLogin();

    if (!isAdmin()) {
        http_response_code(403);
        exit("Access denied.");
    }
}

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
