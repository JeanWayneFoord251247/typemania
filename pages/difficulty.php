<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #ff9142 100%);";

$mode = $_GET['mode'] ?? 'rush';

if (!in_array($mode, ['rush', 'chase', 'race'])) {
    header("Location: play.php");
    exit;
}

$is_matchmaking = ($mode === 'race');

$difficulty_content = [
    'rush' => [
        'easy'   => 'Generous Starting Timer And Shorter Text Passages. Each Word Typed Grants Standard Bonus Time To Keep Your Streak Alive.',
        'medium' => 'Shorter Starting Timer And Longer Text Blocks. Words Grant 1.5x Bonus Time, Requiring A Steady, Efficient Typing Rhythm To Stay Ahead Of The Clock.',
        'hard'   => 'Strict Starting Timer With Dense, Lengthy Text Passages. Every Completed Word Awards A Massive 2.0x Bonus Time, High Risk, But Essential For Maintaining Momentum Under Extreme Time Pressure!'
    ],
    'chase' => [
        'easy'   => 'A Slow-Moving Chaser And Manageable Text Lengths. Ideal For Getting Used To The Pressure Without Getting Caught Instantly.',
        'medium' => 'Increased Chaser Speed And Longer Word Streams. Demands Higher Accuracy And Continuous Typing Speed To Prevent The Color Bar From Catching Up.',
        'hard'   => 'An Relentless, High-Speed Chaser Combined With Massive Text Blocks. One Slip-Up Or Brief Pause Will Cost You The Run, But Surviving Yields Maximum Points And Distance Record Multipliers!'
    ]
];

$circle_color = $_SESSION['circle_color'] ?? "#00D4FF";
$letter_color = $_SESSION['letter_color'] ?? "#00D4FF";
$clean_name   = trim($_SESSION['username'] ?? 'TYPEMANIA');

if (strlen($clean_name) >= 2) {
    $avatar_initials = strtoupper(substr($clean_name, 0, 2));
} elseif (strlen($clean_name) === 1) {
    $avatar_initials = strtoupper($clean_name) . "_";
} else {
    $avatar_initials = "TM";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - <?php echo $is_matchmaking ? 'Matchmaking' : 'Select Difficulty'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/difficulty.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">
    <?php include '../Components/afterNavbar.php'; ?>
    
    <main class="content-wrapper">
    <?php if (!$is_matchmaking): ?>
        
        <h1 class="glitch-title">SELECT YOUR DIFFICULTY</h1>
        
        <div class="difficulty-grid">
            <a href="./gameplay.php?mode=<?php echo $mode; ?>&difficulty=easy" class="diff-card card-easy">
                <div class="diff-content">
                    <h2 class="diff-title">EASY</h2>
                    <p class="diff-desc"><?php echo $difficulty_content[$mode]['easy']; ?></p>
                </div>
            </a>

            <a href="./gameplay.php?mode=<?php echo $mode; ?>&difficulty=medium" class="diff-card card-medium">
                <div class="diff-content">
                    <h2 class="diff-title glitch-text">MEDIUM</h2>
                    <p class="diff-desc"><?php echo $difficulty_content[$mode]['medium']; ?></p>
                </div>
            </a>

            <a href="./gameplay.php?mode=<?php echo $mode; ?>&difficulty=hard" class="diff-card card-hard">
                <div class="diff-content">
                    <h2 class="diff-title glitch-text">HARD</h2>
                    <p class="diff-desc"><?php echo $difficulty_content[$mode]['hard']; ?></p>
                </div>
            </a>
        </div>

        <?php else: ?>
        <h1 class="glitch-title">MATCHMAKING</h1>
        <div class="matchmaking-container">
            <div class="versus-wrapper">
                <div class="player-slot">
                    <div class="avatar-card" style="border: 2px solid <?php echo $circle_color; ?>; box-shadow: 0 0 20px <?php echo $circle_color; ?>;">
                        <div class="avatar-circle">
                            <span style="color: <?php echo $letter_color; ?>; font-size: 52px; font-weight: bold;"><?php echo $avatar_initials; ?></span>
                        </div>
                    </div>
                    <span class="player-tag"><?php echo htmlspecialchars($clean_name); ?></span>
                </div>

                <div class="versus-badge">X</div>

                <div class="player-slot">
                    <div class="avatar-card" style="border: 2px solid #ff9142; box-shadow: 0 0 20px #ff9142;">
                        <div class="avatar-circle">
                            <span style="color: #ff9142; font-size: 52px; font-weight: bold;">OP</span>
                        </div>
                    </div>
                    <span class="player-tag">Username#38698</span>
                </div>

            </div>

            <a href="./gameplay.php?mode=race&match=live" class="btn-start-match">START MATCH 1/2</a>
        </div>
    <?php endif; ?>
</main>

<?php include '../Components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>