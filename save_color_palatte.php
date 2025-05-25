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

$baseColor = $input['base_color'] ?? '';
$harmonyType = $input['harmony_type'] ?? '';
$colors = $input['colors'] ?? [];

if (empty($baseColor) || empty($harmonyType) || empty($colors)) {
    http_response_code(400);
    echo json_encode(['error' => 'Base color, harmony type, and colors are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO color_palettes (base_color, harmony_type, colors) VALUES (?, ?, ?)");
    $stmt->execute([$baseColor, $harmonyType, json_encode($colors)]);
    
    echo json_encode([
        'success' => true,
        'id' => $pdo->lastInsertId(),
        'message' => 'Color palette saved successfully'
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
