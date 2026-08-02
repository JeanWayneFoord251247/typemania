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
    <link rel="stylesheet" href="./css/homepage.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">

    <?php include './Components/beforeNavbar.php'; ?>

    <main class="main-content">
        <section class="hero-section">
            <h1 class="hero-title">
                <span class="type-part">TYPE</span><span class="mania-part">MANIA</span>
            </h1>

            <p class="hero-tagline">
                Think you’re fast? Put your fingers to the test. Compete against the clock,
                climb the leaderboards, and unleash your maximum WPM.
            </p>

            <div class="hero-buttons">
                <a href="./pages/signUp.php" class="hero-btn btn-primary-glow">START TYPING NOW</a>
                <a href="./ranks.php" class="hero-btn btn-secondary-glow">RANKS</a>
            </div>
        </section>
    </main>

    <?php include './Components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>