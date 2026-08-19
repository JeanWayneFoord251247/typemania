<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($conn)) {
    require_once __DIR__ . '/../config/config.php';
}

$user_id = $_SESSION['user_id'] ?? null;

$diff_multiplier_map = [
    'easy'   => '1.0x',
    'medium' => '1.5x',
    'hard'   => '2.0x'
];

$diff_badge_classes = [
    'easy'   => 'badge-green',
    'medium' => 'badge-yellow',
    'hard'   => 'badge-red'
];

$rush_record  = ['wpm' => 0, 'difficulty' => 'easy'];
$chase_record = ['words_typed' => 0, 'difficulty' => 'easy', 'mistakes' => 0];
$race_record  = ['duration_seconds' => 0, 'difficulty' => 'easy', 'accuracy' => 100];

if ($user_id) {
    $rush_stmt = $conn->prepare("
        SELECT wpm, difficulty 
        FROM game_scores 
        WHERE user_id = ? AND mode_id = 1 
        ORDER BY wpm DESC, points DESC 
        LIMIT 1
    ");
    $rush_stmt->bind_param("i", $user_id);
    $rush_stmt->execute();
    $rush_record = $rush_stmt->get_result()->fetch_assoc() ?? $rush_record;
    $rush_stmt->close();

    $chase_stmt = $conn->prepare("
        SELECT words_typed, difficulty, mistakes 
        FROM game_scores 
        WHERE user_id = ? AND mode_id = 2 
        ORDER BY words_typed DESC, points DESC 
        LIMIT 1
    ");
    $chase_stmt->bind_param("i", $user_id);
    $chase_stmt->execute();
    $chase_record = $chase_stmt->get_result()->fetch_assoc() ?? $chase_record;
    $chase_stmt->close();

    $race_stmt = $conn->prepare("
        SELECT duration_seconds, difficulty, accuracy 
        FROM game_scores 
        WHERE user_id = ? AND mode_id = 3 AND duration_seconds > 0 
        ORDER BY duration_seconds ASC, accuracy DESC 
        LIMIT 1
    ");
    $race_stmt->bind_param("i", $user_id);
    $race_stmt->execute();
    $race_record = $race_stmt->get_result()->fetch_assoc() ?? $race_record;
    $race_stmt->close();
}
?>

<link rel="stylesheet" href="/typemania/css/statsCards.css">

<div class="stats-cards-container">

    <div class="stat-card neon-lime">
        <div class="stat-card-left">
            <h3 class="stat-title">Personal Best Velocity</h3>
            <div class="stat-badges">
                <span class="badge mode-badge badge-green">TYPE <span class="game">RUSH</span></span>
                <span class="badge multiplier-badge <?php echo $diff_badge_classes[$rush_record['difficulty']] ?? 'badge-green'; ?>">
                    <?php echo $diff_multiplier_map[$rush_record['difficulty']] ?? '1.0x'; ?>
                </span>
            </div>
            <p class="stat-description">
                Your highest recorded speed across all Rush attempts.
            </p>
        </div>
        <div class="stat-card-right">
            <div class="stat-metric">
                <span class="metric-number"><?php echo (int)$rush_record['wpm']; ?></span>
                <span class="metric-unit">WPM</span>
            </div>
            <a href="pages/gameplay.php?mode=rush&difficulty=<?php echo urlencode($rush_record['difficulty']); ?>" class="action-btn text-decoration-none">Let's Rush</a>
        </div>
    </div>

    <div class="stat-card neon-yellow">
        <div class="stat-card-left">
            <h3 class="stat-title">Longest Survival</h3>
            <div class="stat-badges">
                <span class="badge mode-badge badge-yellow">TYPE <span class="game">CHASE</span></span>
                <span class="badge multiplier-badge <?php echo $diff_badge_classes[$chase_record['difficulty']] ?? 'badge-green'; ?>">
                    <?php echo $diff_multiplier_map[$chase_record['difficulty']] ?? '1.0x'; ?>
                </span>
            </div>
            <p class="stat-description">
                <?php echo number_format((int)$chase_record['words_typed']); ?> Words typed before elimination (<?php echo (int)$chase_record['mistakes']; ?> mistakes).
            </p>
        </div>
        <div class="stat-card-right">
            <div class="stat-metric">
                <span class="metric-number"><?php echo (int)$chase_record['words_typed']; ?></span>
                <span class="metric-unit">WT</span>
            </div>
            <a href="pages/gameplay.php?mode=chase&difficulty=<?php echo urlencode($chase_record['difficulty']); ?>" class="action-btn text-decoration-none">Let's Chase</a>
        </div>
    </div>

    <div class="stat-card neon-orange">
        <div class="stat-card-left">
            <h3 class="stat-title">Fastest Sprint Time</h3>
            <div class="stat-badges">
                <span class="badge mode-badge badge-orange">TYPE <span class="game">RACE</span></span>
                <span class="badge multiplier-badge <?php echo $diff_badge_classes[$race_record['difficulty']] ?? 'badge-green'; ?>">
                    <?php echo $diff_multiplier_map[$race_record['difficulty']] ?? '1.0x'; ?>
                </span>
            </div>
            <p class="stat-description">
                Fastest clear: <?php echo (int)$race_record['duration_seconds']; ?>s at <?php echo number_format((float)$race_record['accuracy'], 1); ?>% accuracy.
            </p>
        </div>
        <div class="stat-card-right">
            <div class="stat-metric">
                <span class="metric-number"><?php echo (int)$race_record['duration_seconds']; ?></span>
                <span class="metric-unit">S</span>
            </div>
            <a href="pages/gameplay.php?mode=race&difficulty=<?php echo urlencode($race_record['difficulty']); ?>" class="action-btn text-decoration-none">Let's Race</a>
        </div>
    </div>

</div>