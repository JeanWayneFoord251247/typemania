<?php
$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #F97316 100%);";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/afterSignUp.css">
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
                <a href="./pages/signUp.php" class="hero-btn btn-primary-glow">PLAY</a>
                <a href="./ranks.php" class="hero-btn btn-secondary-glow">VIEW RANKS</a>
            </div>

            <div class="quick-tips-card">
                <h3 class="quick-tips-title">Quick Tips:</h3>
                <p class="quick-tips-text">
                    Focus on accuracy over raw speed! Fewer mistakes mean higher combo multipliers<br>
                    and a better overall WPM score.
                </p>
            </div>
        </section>

        <section class="achievements-section">
            <div class="achievements-title">TOP ACHIEVEMENTS</div>

            <?php include '../Components/statsCards.php'; ?>
        </section>
    </main>

    <?php include '../Components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>