<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/gameplay.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?> --theme-color: <?php echo $active_theme['color']; ?>;">
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

    <script>

        const GAME_MODE = "<?php echo $mode; ?>";
        const GAME_DIFFICULTY = "<?php echo $difficulty; ?>";
        const THEME_COLOR = "<?php echo $active_theme['color']; ?>";

        const passages = [
            "To Truly Master The Mechanics Of Real-Time Typography, One Must Transcend Basic Muscle Memory And Embrace Absolute, Unyielding Accuracy.",
            "A Single Momentary Lapse In Concentration, A Slip On A Semicolon, Or A Misjudged Dash Will Instantly Terminate Your Winning Streak!",
            "Do Not Succumb To The Immense Pressure Of The Ticking Clock; Instead, Channel Your Inner Velocity And Strike Each Key With Precision."
        ];

        let currentPassageIndex = 0;
        let totalCharsTyped = 0;
        let prevInputLength = 0;
        let startTime = null;
        let timeLeft = 60;
        let currentLives = 5;
        const maxLives = 5;
        let chaserIndex = -6;
        let gameTimerInterval = null;
        let chaserInterval = null;

        const textDisplay = document.getElementById('text-display');
        const typeInput = document.getElementById('type-input');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const countdownNumber = document.getElementById('countdown-number');
        const timerElement = document.getElementById('game-timer');
        const livesIndicator = document.getElementById('passage-progress');
        const statAccuracy = document.getElementById('stat-accuracy');
        const statWpm = document.getElementById('stat-wpm');
        const statMultiplier = document.getElementById('stat-multiplier');

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins < 10 ? '0' : ''}${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        function renderPassage(index) {
            textDisplay.innerHTML = '';
            const text = passages[index];
            text.split('').forEach((char, i) => {
                const span = document.createElement('span');
                span.innerText = char;
                if (i === 0) span.classList.add('char-current');
                textDisplay.appendChild(span);
            });
        }

        function startCountdown() {
            renderPassage(currentPassageIndex);
            let count = 3;
            
            const interval = setInterval(() => {
                count--;
                if (count > 0) {
                    countdownNumber.innerText = count;
                } else if (count === 0) {
                    countdownNumber.innerText = 'GO!';
                } else {
                    clearInterval(interval);
                    countdownOverlay.style.display = 'none';
                    typeInput.disabled = false;
                    typeInput.focus();
                    startGame();
                }
            }, 1000);
        }

        function startGame() {
            if (GAME_MODE !== 'chase') {
                timerElement.innerText = formatTime(timeLeft);
                gameTimerInterval = setInterval(() => {
                    timeLeft--;
                    timerElement.innerText = formatTime(timeLeft);
                    if (timeLeft <= 0) {
                        clearInterval(gameTimerInterval);
                        typeInput.disabled = true;
                        showEndModal("TIME'S UP", "You ran out of time before completing the challenge.");
                    }
                }, 1000);
            }

            if (GAME_MODE === 'chase') {
                const chaserSpeeds = { 'easy': 400, 'medium': 250, 'hard': 150 };
                const speed = chaserSpeeds[GAME_DIFFICULTY] || 300;

                chaserInterval = setInterval(() => {
                    chaserIndex++;
                    const spans = textDisplay.querySelectorAll('span');
                    
                    if (chaserIndex >= 0 && chaserIndex < spans.length) {
                        spans[chaserIndex].classList.add('char-chased');
                    }

                    if (chaserIndex >= typeInput.value.length) {
                        clearInterval(chaserInterval);
                        typeInput.disabled = true;
                        showEndModal("ELIMINATED", "The chaser caught up to you!");
                    }
                }, speed);
            }
        }

        function updateMetrics(typedLength) {
            const elapsedMinutes = (Date.now() - startTime) / 60000;
            const wpm = elapsedMinutes > 0 ? Math.round((typedLength / 5) / elapsedMinutes) : 0;
            statWpm.innerText = wpm;
        }

        typeInput.addEventListener('input', () => {
            if (!startTime) startTime = Date.now();
            const spans = textDisplay.querySelectorAll('span');
            const userVal = typeInput.value.split('');
            let correctCount = 0;

            spans.forEach((span, index) => {
                const char = userVal[index];
                span.className = '';

                if (GAME_MODE === 'chase' && index <= chaserIndex) {
                    span.classList.add('char-chased');
                }
                if (char == null) {
                    if (index === userVal.length) span.classList.add('char-current');
                } else if (char === span.innerText) {
                    span.classList.add('char-correct');
                    correctCount++;
                } else {
                    span.classList.add('char-incorrect');
                }
            });

            const totalTypedNow = totalCharsTyped + userVal.length;
            const totalCorrectNow = totalCharsTyped + correctCount;
            const acc = totalTypedNow > 0 ? Math.round((totalCorrectNow / totalTypedNow) * 100) : 100;
            statAccuracy.innerText = `${acc}%`;
            updateMetrics(totalCorrectNow);

            const lastTypedIndex = userVal.length - 1;
            if (lastTypedIndex >= 0 && userVal.length > prevInputLength) {
                const targetChar = spans[lastTypedIndex].innerText;
                const typedChar = userVal[lastTypedIndex];

                if (typedChar !== targetChar) {
                    currentLives = Math.max(0, currentLives - 1);
                    livesIndicator.innerText = `${currentLives}/${maxLives}`;
                    livesIndicator.style.color = '#FF3B30';
                    setTimeout(() => { livesIndicator.style.color = '#FFFFFF'; }, 200);

                    if (currentLives <= 0) {
                        if (gameTimerInterval) clearInterval(gameTimerInterval);
                        if (chaserInterval) clearInterval(chaserInterval);
                        typeInput.disabled = true;
                        showEndModal("OUT OF LIVES", "You made too many mistakes.");
                        return;
                    }
                }
            }
            prevInputLength = userVal.length;

            if (userVal.length === spans.length && correctCount === spans.length) {
                totalCharsTyped += spans.length;
                currentPassageIndex = (currentPassageIndex + 1) % passages.length;
                typeInput.value = '';
                prevInputLength = 0;
                chaserIndex = -6;
                renderPassage(currentPassageIndex);
            }
        });

        function populateModeStats(statsContainer) {
            const totalWords = Math.round((totalCharsTyped + typeInput.value.length) / 5);
            const finalAccuracy = statAccuracy.innerText;
            const finalWpm = statWpm.innerText;

            if (GAME_MODE === 'rush') {
                const peakMultiplier = statMultiplier ? statMultiplier.innerText : '1.0X';
                statsContainer.innerHTML = `
                    <div class="modal-stat-item"><span class="stat-big">${totalWords}</span><span class="stat-sub">WORDS CLEARED</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${finalAccuracy}</span><span class="stat-sub">ACCURACY</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${peakMultiplier}</span><span class="stat-sub">PEAK MULTIPLIER</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">WPM</span></div>
                `;
            } else if (GAME_MODE === 'chase') {
                statsContainer.innerHTML = `
                    <div class="modal-stat-item"><span class="stat-big">${totalWords}</span><span class="stat-sub">WORDS TYPED</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${currentLives}/${maxLives}</span><span class="stat-sub">LIVES LEFT</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">PEAK WPM</span></div>
                `;
            } else if (GAME_MODE === 'race') {
                const timeSpent = Math.max(1, 60 - timeLeft);
                statsContainer.innerHTML = `
                    <div class="modal-stat-item"><span class="stat-big">${timeSpent}s</span><span class="stat-sub">TIME TAKEN</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${finalAccuracy}</span><span class="stat-sub">ACCURACY</span></div>
                    <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">RACE WPM</span></div>
                `;
            }
        }

        function showEndModal(title, description) {
            if (gameTimerInterval) clearInterval(gameTimerInterval);
            if (chaserInterval) clearInterval(chaserInterval);
            typeInput.disabled = true;

            const modal = document.getElementById('game-modal');
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-desc').innerText = description;
            
            const statsContainer = document.getElementById('modal-stats-container');
            populateModeStats(statsContainer);

            modal.style.setProperty('display', 'flex', 'important');
        }

        document.getElementById('btn-restart').addEventListener('click', () => location.reload());
        const modalRetry = document.getElementById('modal-btn-retry');
        if (modalRetry) modalRetry.addEventListener('click', () => location.reload());

        document.querySelector('.typing-arena').addEventListener('click', () => {
            if (!typeInput.disabled) typeInput.focus();
        });

        typeInput.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            startCountdown();
        });

</script>
</body>
</html>