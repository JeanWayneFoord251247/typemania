<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';

$mode = isset($_GET['mode']) ? strtolower($_GET['mode']) : 'rush';
if (!in_array($mode, ['rush', 'chase', 'race'])) {
    $mode = 'rush';
}

$mode_id_map = [
    'rush'  => 1,
    'chase' => 2,
    'race'  => 3
];
$active_mode_id = $mode_id_map[$mode];
$logged_in_user_id = $_SESSION['user_id'] ?? null;

$bg_style = "background: linear-gradient(115deg, #ff9142 0%, #FFF700 35%, #19EC06 60%, #00D4FF 100%);";

$modeVisuals = [
    'rush' => [
        'border'  => '#19EC06',
        'glow'    => 'rgba(25, 236, 6, 0.4)',
        'bgGlow'  => 'rgba(25, 236, 6, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'WORDS', 'POINTS']
    ],
    'chase' => [
        'border'  => '#FFF700',
        'glow'    => 'rgba(255, 247, 0, 0.4)',
        'bgGlow'  => 'rgba(255, 247, 0, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'POINTS', 'WORDS']
    ],
    'race' => [
        'border'  => '#ff9142',
        'glow'    => 'rgba(249, 115, 22, 0.4)',
        'bgGlow'  => 'rgba(249, 115, 22, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'POINTS', 'FINISH TIME']
    ]
];

$currentConfig = $modeVisuals[$mode];

$rank_query = $conn->prepare("
    SELECT 
        u.user_id,
        u.username,
        u.letter_color,
        MAX(gs.points) AS top_points,
        MAX(gs.wpm) AS top_wpm,
        MAX(gs.words_typed) AS max_words,
        MIN(NULLIF(gs.duration_seconds, 0)) AS quickest_time
    FROM game_scores gs
    JOIN users u ON gs.user_id = u.user_id
    WHERE gs.mode_id = ?
    GROUP BY u.user_id, u.username, u.letter_color
    ORDER BY top_points DESC, top_wpm DESC
");
$rank_query->bind_param("i", $active_mode_id);
$rank_query->execute();
$all_scores = $rank_query->get_result()->fetch_all(MYSQLI_ASSOC);
$rank_query->close();

$all_leaderboard_rows = [];
$user_rank_data = null;
$position = 1;

foreach ($all_scores as $entry) {
    $time_formatted = $entry['quickest_time'] ? gmdate("i:s", $entry['quickest_time']) : '--:--';
    $points_formatted = number_format((int)$entry['top_points']);
    $words_formatted = number_format((int)$entry['max_words']);

    if ($mode === 'rush') {
        $formatted_row = ["#{$position}", $entry['username'], $entry['top_wpm'], $words_formatted, $points_formatted];
    } elseif ($mode === 'chase') {
        $formatted_row = ["#{$position}", $entry['username'], $entry['top_wpm'], $points_formatted, "{$words_formatted} WT"];
    } else {
        $formatted_row = ["#{$position}", $entry['username'], $entry['top_wpm'], $points_formatted, $time_formatted];
    }

    $all_leaderboard_rows[] = $formatted_row;

    if ($logged_in_user_id && (int)$entry['user_id'] === (int)$logged_in_user_id) {
        $user_rank_data = $formatted_row;
    }

    $position++;
}

if (!$user_rank_data && $logged_in_user_id) {
    $user_name_fallback = $_SESSION['username'] ?? 'TYPEMANIA';
    if ($mode === 'rush') {
        $user_rank_data = ['#--', $user_name_fallback, '0', '0', '0'];
    } elseif ($mode === 'chase') {
        $user_rank_data = ['#--', $user_name_fallback, '0', '0', '0 WT'];
    } else {
        $user_rank_data = ['#--', $user_name_fallback, '0', '0', '--:--'];
    }
}

$dynamicCardStyle = "style=\"border-color: {$currentConfig['border']}; box-shadow: 0 0 25px {$currentConfig['glow']};\"";
$dynamicTabsStyle = "style=\"border-color: {$currentConfig['border']}; box-shadow: 0 0 18px {$currentConfig['glow']};\"";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Leaderboards</title>

    <link rel="stylesheet" href="../css/ranks.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="ranks-container">

        <div class="mode-tabs-wrapper">
            <div class="mode-tabs" <?php echo $dynamicTabsStyle; ?>>
                <a href="ranks.php?mode=rush" class="tab-btn <?php echo $mode === 'rush' ? 'active' : ''; ?>" <?php echo $mode === 'rush' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'rush' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>RUSH</span></a>
                <a href="ranks.php?mode=chase" class="tab-btn <?php echo $mode === 'chase' ? 'active' : ''; ?>" <?php echo $mode === 'chase' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'chase' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>CHASE</span></a>
                <a href="ranks.php?mode=race" class="tab-btn <?php echo $mode === 'race' ? 'active' : ''; ?>" <?php echo $mode === 'race' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'race' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>RACE</span></a>
            </div>
        </div>

        <div class="leaderboard-card" <?php echo $dynamicCardStyle; ?>>

            <div class="leaderboard-header">
                <?php foreach ($currentConfig['headers'] as $header): ?>
                    <div class="col-item"><?php echo $header; ?></div>
                <?php endforeach; ?>
            </div>

            <div class="leaderboard-body">
                <?php if (!empty($all_leaderboard_rows)): ?>
                    <?php foreach ($all_leaderboard_rows as $row): ?>
                        <div class="leaderboard-row">
                            <div class="col-item"><?php echo htmlspecialchars($row[0]); ?></div>
                            <div class="col-item"><?php echo htmlspecialchars($row[1]); ?></div>
                            <div class="col-item"><?php echo htmlspecialchars($row[2]); ?></div>
                            <div class="col-item"><?php echo htmlspecialchars($row[3]); ?></div>
                            <div class="col-item"><?php echo htmlspecialchars($row[4]); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="leaderboard-row text-center">
                        <div class="col-item" style="grid-column: 1 / -1; width: 100%; opacity: 0.6;">No matches recorded for this mode yet.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($user_rank_data): ?>
            <div class="personal-rank-card" <?php echo $dynamicCardStyle; ?>>
                <div class="col-item"><?php echo htmlspecialchars($user_rank_data[0]); ?></div>
                <div class="col-item">
                    <?php echo htmlspecialchars($user_rank_data[1]); ?>
                    <span class="badge-you" style="color: <?php echo $currentConfig['border']; ?>;">(YOU)</span>
                </div>
                <div class="col-item"><?php echo htmlspecialchars($user_rank_data[2]); ?></div>
                <div class="col-item"><?php echo htmlspecialchars($user_rank_data[3]); ?></div>
                <div class="col-item"><?php echo htmlspecialchars($user_rank_data[4]); ?></div>
            </div>
        <?php endif; ?>

    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>