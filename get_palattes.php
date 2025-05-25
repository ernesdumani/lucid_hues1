<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $stmt = $pdo->prepare("SELECT * FROM dream_palettes ORDER BY created_at DESC LIMIT 50");
    $stmt->execute();
    $palettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Decode JSON colors for each palette
    foreach ($palettes as &$palette) {
        $palette['colors'] = json_decode($palette['colors'], true);
    }
    
    echo json_encode($palettes);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
