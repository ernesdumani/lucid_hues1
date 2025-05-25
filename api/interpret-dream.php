<?php
require_once '../config.php';
require_once '../dream-interpreter.php';

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

$dreamText = $input['dreamText'] ?? '';

if (empty($dreamText)) {
    http_response_code(400);
    echo json_encode(['error' => 'Dream text is required']);
    exit;
}

try {
    $interpretation = DreamInterpreter::interpretDream($dreamText);
    
    // Save to database
    $stmt = $pdo->prepare("INSERT INTO dream_palettes (dream_text, colors, mood, emotions, symbols, title) VALUES (?, ?, ?, ?, ?, ?)");
    $colors = array_column($interpretation['colorSuggestions'], 'color');
    $title = 'Dream ' . date('Y-m-d H:i');
    
    $stmt->execute([
        $dreamText,
        json_encode($colors),
        $interpretation['overallMood'],
        json_encode($interpretation['emotions']),
        json_encode($interpretation['symbols']),
        $title
    ]);
    
    echo json_encode($interpretation);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to interpret dream: ' . $e->getMessage()]);
}
?>
