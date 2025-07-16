<?php
header("Content-Type: application/json");

$status = isset($_GET['status']) ? (int)$_GET['status'] : 200;

http_response_code($status);

echo json_encode([
    'message' => "This is a sample message."
], JSON_PRETTY_PRINT);