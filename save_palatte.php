<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$dreamText = $input['dream_text'] ?? '';
$colors = $input['colors'] ?? [];
$mood = $input['mood'] ?? '';

if (empty($dreamText) || empty($colors)) {
    http_response_code(400);
    echo json_encode(['error' => 'Dream text and colors are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO dream_palettes (dream_text, colors, mood) VALUES (?, ?, ?)");
    $stmt->execute([$dreamText, json_encode($colors), $mood]);
    
    echo json_encode([
        'success' => true,
        'id' => $pdo->lastInsertId(),
        'message' => 'Palette saved successfully'
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
