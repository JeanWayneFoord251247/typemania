<?php
$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #ff9142 100%);";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Select Challenge</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/play.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="play-container">

        <h1 class="play-title">SELECT YOUR CHALLENGE</h1>

        <div class="challenge-grid">

            <a href="./difficulty.php?mode=rush" class="challenge-card card-rush">
                <div class="card-content">
                    <h2 class="card-title">TYPE<span class="highlight">RUSH</span></h2>
                    <p class="card-description">
                        A High-Stakes, Fast-Paced Speed Test. Outrun A Shrinking Timer Where Every Correct Sentence Buys You Extra Seconds To Keep The Rush Going.
                    </p>
                </div>
            </a>

            <a href="./difficulty.php?mode=chase" class="challenge-card card-chase">
                <div class="card-content">
                    <h2 class="card-title">TYPE<span class="highlight">CHASE</span></h2>
                    <p class="card-description">
                        Stay Ahead Of The Hunter. Maintain A Strict Target WPM To Keep Distance, Let The Pace Slip For Too Long, And The Chase Is Over.
                    </p>
                </div>
            </a>

            <a href="./difficulty.php?mode=race" class="challenge-card card-race">
                <div class="card-content">
                    <h2 class="card-title">TYPE<span class="highlight">RACE</span></h2>
                    <p class="card-description">
                        Head-To-Head Competitive Typing. Line Up On The Grid, Hit Top Speed, And Cross The Finish Line First Against Live Rivals Or Ghost Racers.
                    </p>
                </div>
            </a>

        </div>
    </main>

    <?php include '../Components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>