<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #ff9142 100%);";
$quick_tips = [
    "Focus on accuracy over raw speed! Fewer mistakes mean higher combo multipliers and a better overall WPM score.",
    "Keep your eyes ahead of what you are typing! Anticipating the next word prevents stuttering and maintains rhythm.",
    "Maintain steady finger placement on the home row (ASDF JKL;) to build reliable muscle memory.",
    "Pacing beats rushing! A consistent 70 WPM with 99% accuracy will outscore a chaotic 90 WPM with high error rates.",
    "Take short breaks between high-intensity typing sessions to avoid hand fatigue and keep your reflexes sharp.",
    "Practice difficult key combinations slowly before pushing for max speed in competitive modes."
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania</title>

    <link rel="stylesheet" href="../css/afterSignUp.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="main-content">
        <section class="hero-section">
            <h1 class="hero-title">
                <span class="type-part">TYPE</span><span class="mania-part">MANIA</span>
            </h1>

            <p class="hero-tagline">
                Where chaotic speed meets surgical precision: welcome back<br>
                to the mania, it's time to break the limits.
            </p>

            <div class="hero-buttons">
                <a href="../pages/play.php" class="hero-btn btn-primary-glow">PLAY</a>
                <a href="../pages/ranks.php" class="hero-btn btn-secondary-glow">VIEW RANKS</a>
            </div>

            <div class="quick-tips-card">
                <h3 class="quick-tips-title">Quick Tip:</h3>
                <p 
                    class="quick-tips-text" 
                    id="quick-tip-display" 
                    data-tips='<?php echo htmlspecialchars(json_encode($quick_tips), ENT_QUOTES, 'UTF-8'); ?>'
                >
                    <?php echo htmlspecialchars($quick_tips[0]); ?>
                </p>
            </div>
        </section>

        <section class="achievements-section">
            <div class="achievements-title">TOP ACHIEVEMENTS</div>

            <?php include '../Components/statsCards.php'; ?>
        </section>
    </main>

    <?php include '../Components/footer.php'; ?>

    <script src="../js/afterSignUp.js?v=<?php echo time(); ?>" defer></script>
</body>

</html>