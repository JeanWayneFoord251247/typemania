<?php
require_once __DIR__ . '/../config/config.php';

$mode = $_GET['mode'] ?? 'rush';
$difficulty = $_GET['difficulty'] ?? 'easy';

if (!in_array($mode, ['rush', 'chase', 'race'])) {
    header("Location: play.php");
    exit;
}

$theme_colors = [
    'rush'  => ['color' => '#19EC06', 'title' => "Let's Rush", 'watermark' => 'TYPERUSH', 'timer_label' => '01:00'],
    'chase' => ['color' => '#FFF700', 'title' => "Let's Chase", 'watermark' => 'TYPECHASE', 'timer_label' => '80WT'],
    'race'  => ['color' => '#FF9142', 'title' => "Let's Race", 'watermark' => 'TYPERACE', 'timer_label' => '01:00']
];

$active_theme = $theme_colors[$mode];
$bg_style = "background: linear-gradient(115deg, #FFF700 0%, #19EC06 35%,  #00D4FF 60%, #FF9142 100%);";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - <?php echo htmlspecialchars($active_theme['watermark']); ?></title>
    <link rel="stylesheet" href="../css/gameplay.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?> --theme-color: <?php echo $active_theme['color']; ?>;">

    <!-- Hidden config container for external JavaScript -->
    <div id="game-config"
        data-mode="<?php echo htmlspecialchars($mode); ?>"
        data-difficulty="<?php echo htmlspecialchars($difficulty); ?>"
        data-theme-color="<?php echo htmlspecialchars($active_theme['color']); ?>"
        style="display: none;"></div>

    <div class="game-top-controls">
        <a href="./play.php" class="btn-pill-control" style="border: 2px solid <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 15px <?php echo $active_theme['color']; ?>80;">CANCEL</a>
        <button id="btn-restart" class="btn-pill-control" style="border: 2px solid <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 15px <?php echo $active_theme['color']; ?>80;">RESTART</button>
    </div>

    <div id="countdown-overlay" class="countdown-overlay">
        <div id="countdown-number" class="countdown-text" style="color: <?php echo $active_theme['color']; ?>; text-shadow: 0px 0px 30px <?php echo $active_theme['color']; ?>;">3</div>
    </div>

    <main class="game-wrapper">
        <div class="game-card" style="border: 3px solid <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 30px <?php echo $active_theme['color']; ?>;">

            <div class="timer-badge" style="border: 3px solid <?php echo $active_theme['color']; ?>; color: <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 20px <?php echo $active_theme['color']; ?>80;">
                <span id="game-timer"><?php echo htmlspecialchars($active_theme['timer_label']); ?></span>
            </div>

            <div class="subhead-row">
                <span class="subhead-title"><?php echo htmlspecialchars($active_theme['title']); ?></span>
                <span id="passage-progress" class="subhead-counter">5/5</span>
            </div>

            <div class="typing-arena">
                <p id="text-display" class="text-display"></p>
                <input type="text" id="type-input" class="hidden-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" disabled>
            </div>

            <div class="watermark-title">
                <span class="watermark-prefix">TYPE</span>
                <span class="watermark-mode"><?php echo strtoupper(htmlspecialchars($mode)); ?></span>
            </div>
        </div>

        <div class="hud-stats-bar" style="border: 2px solid <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 20px <?php echo $active_theme['color']; ?>80;">
            <div class="stat-box">
                <span id="stat-accuracy" class="stat-value">100%</span>
                <span class="stat-label">ACCURACY</span>
            </div>
            <div class="stat-box">
                <span id="stat-wpm" class="stat-value">0</span>
                <span class="stat-label">WPM</span>
            </div>
            <div class="stat-box">
                <span id="stat-multiplier" class="stat-value">1.0X</span>
                <span class="stat-label">MULTIPLIER</span>
            </div>
        </div>

        <?php include __DIR__ . '/../Components/modal.php'; ?>

    </main>

    <script src="../js/gameplay.js?v=<?php echo time(); ?>" defer></script>
</body>

</html>