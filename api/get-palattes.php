<?php
require_once '../config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$type = $_GET['type'] ?? 'dream'; // 'dream' or 'color'

try {
    if ($type === 'dream') {
        $stmt = $pdo->prepare("SELECT * FROM dream_palettes ORDER BY created_at DESC LIMIT 50");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM color_palettes ORDER BY created_at DESC LIMIT 50");
    }
    
    $stmt->execute();
    $palettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Decode JSON fields for each palette
    foreach ($palettes as &$palette) {
        $palette['colors'] = json_decode($palette['colors'], true);
        if (isset($palette['emotions'])) {
            $palette['emotions'] = json_decode($palette['emotions'], true);
        }
        if (isset($palette['symbols'])) {
            $palette['symbols'] = json_decode($palette['symbols'], true);
        }
    }
    
    echo json_encode($palettes);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
