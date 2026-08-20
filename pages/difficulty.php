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

$difficulty_content = [
    'rush' => [
        'easy'   => 'Generous Starting Timer And Shorter Text Passages. Each Word Typed Grants Standard Bonus Time To Keep Your Streak Alive.',
        'medium' => 'Shorter Starting Timer And Longer Text Blocks. Words Grant 1.5x Bonus Time, Requiring A Steady, Efficient Typing Rhythm To Stay Ahead Of The Clock.',
        'hard'   => 'Strict Starting Timer With Dense, Lengthy Text Passages. Every Completed Word Awards A Massive 2.0x Bonus Time, High Risk, But Essential For Maintaining Momentum Under Extreme Time Pressure!'
    ],
    'chase' => [
        'easy'   => 'A Slow-Moving Chaser And Manageable Text Lengths. Ideal For Getting Used To The Pressure Without Getting Caught Instantly.',
        'medium' => 'Increased Chaser Speed And Longer Word Streams. Demands Higher Accuracy And Continuous Typing Speed To Prevent The Color Bar From Catching Up.',
        'hard'   => 'A Relentless, High-Speed Chaser Combined With Massive Text Blocks. One Slip-Up Or Brief Pause Will Cost You The Run, But Surviving Yields Maximum Points And Distance Record Multipliers!'
    ],
    'race' => [
        'easy'   => 'Generous Target Finish Time. Perfect For Dialing In Steady Rhythm And Nailing Clean Keystrokes.',
        'medium' => 'Tighter Clock Constraints Requiring Fast Pacing And Minimal Typos To Beat The Target.',
        'hard'   => 'Strict Target Time Limit. Demands Maximum WPM And Near-Flawless Accuracy From The Starting Line To The Finish!'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Select Difficulty</title>
    <link rel="stylesheet" href="../css/difficulty.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="content-wrapper">
        <h1 class="glitch-title">SELECT YOUR DIFFICULTY</h1>

        <div class="difficulty-grid">
            <a href="./gameplay.php?mode=<?php echo urlencode($mode); ?>&difficulty=easy" class="diff-card card-easy">
                <div class="diff-content">
                    <h2 class="diff-title">EASY</h2>
                    <p class="diff-desc"><?php echo htmlspecialchars($difficulty_content[$mode]['easy']); ?></p>
                </div>
            </a>

            <a href="./gameplay.php?mode=<?php echo urlencode($mode); ?>&difficulty=medium" class="diff-card card-medium">
                <div class="diff-content">
                    <h2 class="diff-title glitch-text">MEDIUM</h2>
                    <p class="diff-desc"><?php echo htmlspecialchars($difficulty_content[$mode]['medium']); ?></p>
                </div>
            </a>

            <a href="./gameplay.php?mode=<?php echo urlencode($mode); ?>&difficulty=hard" class="diff-card card-hard">
                <div class="diff-content">
                    <h2 class="diff-title glitch-text">HARD</h2>
                    <p class="diff-desc"><?php echo htmlspecialchars($difficulty_content[$mode]['hard']); ?></p>
                </div>
            </a>
        </div>
    </main>

    <?php include '../Components/footer.php'; ?>

</body>

</html>