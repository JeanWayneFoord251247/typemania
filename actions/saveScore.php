<?php
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit();
}

$user_id          = (int)$_SESSION['user_id'];
$mode_str         = $data['mode'] ?? 'rush';
$difficulty       = $data['difficulty'] ?? 'easy';
$wpm              = (int)($data['wpm'] ?? 0);
$accuracy         = (float)($data['accuracy'] ?? 100.0);
$points           = (int)($data['points'] ?? 0);
$duration_seconds = (int)($data['duration_seconds'] ?? 0);
$words_typed      = (int)($data['words_typed'] ?? 0);
$mistakes         = (int)($data['mistakes'] ?? 0);

$mode_map = [
    'rush'  => 1,
    'chase' => 2,
    'race'  => 3
];
$mode_id = $mode_map[$mode_str] ?? 1;

$stmt = $conn->prepare("INSERT INTO game_scores (user_id, mode_id, difficulty, wpm, accuracy, points, duration_seconds, words_typed, mistakes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("iisidiiii", $user_id, $mode_id, $difficulty, $wpm, $accuracy, $points, $duration_seconds, $words_typed, $mistakes);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'score_id' => $conn->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}