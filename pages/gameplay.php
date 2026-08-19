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
            "To truly master the mechanics of real-time typography, one must transcend basic muscle memory and embrace absolute, unyielding accuracy. A single momentary lapse in concentration, a slip on a semicolon, or a misjudged dash will instantly terminate your winning streak! Do not succumb to the immense pressure of the ticking clock; instead, channel your inner velocity and strike each key with unwavering precision as the chaser gains ground behind you."
        ];

        const difficultyMultipliers = {
            'easy': 1.0,
            'medium': 1.5,
            'hard': 2.0
        };
        const baseMultiplier = difficultyMultipliers[GAME_DIFFICULTY] || 1.0;

        const initialTimes = {
            'easy': 90,
            'medium': 75,
            'hard': 60
        };

        let currentPassageIndex = 0;
        let totalCharsTyped = 0;
        let prevInputLength = 0;
        let startTime = null;
        let timeLeft = initialTimes[GAME_DIFFICULTY] || 60;
        let currentLives = 5;
        const maxLives = 5;
        let correctStreak = 0;
        let totalScore = 0;
        let totalMistakes = 0;
        let totalKeystrokes = 0;
        let totalCorrectKeystrokes = 0;
        let currentMultiplier = baseMultiplier;

        let chaserIndex = -6;
        let chaserSpeed = 300;
        let chaserInterval = null;
        let gameTimerInterval = null;

        const textDisplay = document.getElementById('text-display');
        const typeInput = document.getElementById('type-input');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const countdownNumber = document.getElementById('countdown-number');
        const timerElement = document.getElementById('game-timer');
        const livesIndicator = document.getElementById('passage-progress');
        const statAccuracy = document.getElementById('stat-accuracy');
        const statWpm = document.getElementById('stat-wpm');
        const statMultiplier = document.getElementById('stat-multiplier');

        if (statMultiplier) {
            statMultiplier.innerText = `${baseMultiplier.toFixed(1)}X`;
        }

        if (timerElement && GAME_MODE !== 'chase') {
            timerElement.innerText = formatTime(timeLeft);
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins < 10 ? '0' : ''}${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        function calculateFinalScore() {
            return totalScore;
        }

        function updateMetrics() {
            const elapsedMinutes = (Date.now() - startTime) / 60000;
            const wpm = elapsedMinutes > 0 ? Math.round((totalCorrectKeystrokes / 5) / elapsedMinutes) : 0;
            const acc = totalKeystrokes > 0 ? Math.round((totalCorrectKeystrokes / totalKeystrokes) * 100) : 100;
            statWpm.innerText = wpm;
            statAccuracy.innerText = `${acc}%`;
        }

        function updateArenaScroll() {
            const arena = document.querySelector('.typing-arena');
            const currentSpan = textDisplay.querySelector('.char-current');
            if (currentSpan && arena) {
                const spanOffset = currentSpan.offsetTop;
                const arenaCenter = arena.clientHeight / 2;
                arena.scrollTop = spanOffset - arenaCenter;
            }
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

        function startChaserLoop() {
            if (chaserInterval) clearInterval(chaserInterval);

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
            }, chaserSpeed);
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
                const chaserSpeeds = {
                    'easy': 400,
                    'medium': 250,
                    'hard': 150
                };
                chaserSpeed = chaserSpeeds[GAME_DIFFICULTY] || 300;
                startChaserLoop();
            }
        }

        function populateModeStats(statsContainer) {
            const totalWords = Math.round(totalCorrectKeystrokes / 5);
            const finalAccuracy = totalKeystrokes > 0 ? `${Math.round((totalCorrectKeystrokes / totalKeystrokes) * 100)}%` : '100%';
            const finalWpm = statWpm.innerText;
            const finalScore = calculateFinalScore();

            if (GAME_MODE === 'rush') {
                statsContainer.innerHTML = `
                <div class="modal-stat-item"><span class="stat-big">${finalScore}</span><span class="stat-sub">SCORE</span></div>
                <div class="modal-stat-item"><span class="stat-big">${totalWords}</span><span class="stat-sub">WORDS</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalAccuracy}</span><span class="stat-sub">ACCURACY</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">WPM</span></div>
            `;
            } else if (GAME_MODE === 'chase') {
                statsContainer.innerHTML = `
                <div class="modal-stat-item"><span class="stat-big">${finalScore}</span><span class="stat-sub">SCORE</span></div>
                <div class="modal-stat-item"><span class="stat-big">${totalWords}</span><span class="stat-sub">WORDS</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalAccuracy}</span><span class="stat-sub">ACCURACY</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">PEAK WPM</span></div>
            `;
            } else if (GAME_MODE === 'race') {
                const initialTotal = initialTimes[GAME_DIFFICULTY] || 60;
                const timeSpent = Math.max(1, initialTotal - timeLeft);
                statsContainer.innerHTML = `
                <div class="modal-stat-item"><span class="stat-big">${finalScore}</span><span class="stat-sub">SCORE</span></div>
                <div class="modal-stat-item"><span class="stat-big">${timeSpent}s</span><span class="stat-sub">TIME</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalAccuracy}</span><span class="stat-sub">ACCURACY</span></div>
                <div class="modal-stat-item"><span class="stat-big">${finalWpm}</span><span class="stat-sub">WPM</span></div>
            `;
            }
        }

        function savePlayerScore() {
            const finalScore = calculateFinalScore();
            const finalWpm = parseInt(statWpm.innerText) || 0;
            const finalAccuracy = totalKeystrokes > 0 ? Math.round((totalCorrectKeystrokes / totalKeystrokes) * 100) : 100;
            const totalWords = Math.round(totalCorrectKeystrokes / 5);
            const duration = startTime ? Math.round((Date.now() - startTime) / 1000) : 0;

            fetch('../actions/saveScore.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        mode: GAME_MODE,
                        difficulty: GAME_DIFFICULTY,
                        points: finalScore,
                        wpm: finalWpm,
                        accuracy: finalAccuracy,
                        words_typed: totalWords,
                        duration_seconds: duration,
                        mistakes: totalMistakes
                    })
                })
                .then(res => res.json())
                .then(data => console.log('Score saved:', data))
                .catch(err => console.error('Save error:', err));
        }

        function showEndModal(title, description) {
            if (gameTimerInterval) clearInterval(gameTimerInterval);
            if (chaserInterval) clearInterval(chaserInterval);
            typeInput.disabled = true;

            savePlayerScore();

            const modal = document.getElementById('game-modal');
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-desc').innerText = description;

            const statsContainer = document.getElementById('modal-stats-container');
            populateModeStats(statsContainer);

            modal.style.setProperty('display', 'flex', 'important');
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

            const lastTypedIndex = userVal.length - 1;
            if (lastTypedIndex >= 0 && userVal.length > prevInputLength) {
                totalKeystrokes++;
                const targetChar = spans[lastTypedIndex].innerText;
                const typedChar = userVal[lastTypedIndex];

                if (typedChar !== targetChar) {
                    totalMistakes++;
                    correctStreak = 0;
                    currentMultiplier = baseMultiplier;
                    statMultiplier.innerText = `${currentMultiplier.toFixed(1)}X`;

                    if (GAME_MODE === 'chase') {
                        chaserSpeed = Math.max(60, chaserSpeed - 40);
                        startChaserLoop();
                    } else {
                        currentLives = Math.max(0, currentLives - 1);
                        livesIndicator.innerText = `${currentLives}/${maxLives}`;
                        livesIndicator.style.color = '#FF3B30';
                        setTimeout(() => {
                            livesIndicator.style.color = '#FFFFFF';
                        }, 200);

                        if (currentLives <= 0) {
                            if (gameTimerInterval) clearInterval(gameTimerInterval);
                            if (chaserInterval) clearInterval(chaserInterval);
                            typeInput.disabled = true;
                            showEndModal("OUT OF LIVES", "You made too many mistakes.");
                            return;
                        }
                    }
                } else {
                    totalCorrectKeystrokes++;
                    correctStreak++;
                    totalScore += Math.round(10 * currentMultiplier);

                    if (GAME_MODE === 'rush' && (targetChar === ' ' || lastTypedIndex === spans.length - 1)) {
                        timeLeft += 2;
                        timerElement.innerText = formatTime(timeLeft);
                    }

                    if (correctStreak % 15 === 0) {
                        currentMultiplier += 0.1;
                        statMultiplier.innerText = `${currentMultiplier.toFixed(1)}X`;
                    }
                }
            }

            updateMetrics();
            prevInputLength = userVal.length;

            if (userVal.length === spans.length && correctCount === spans.length) {
                totalCharsTyped += spans.length;
                currentPassageIndex++;

                if (currentPassageIndex >= passages.length) {
                    showEndModal("CHALLENGE COMPLETE", "You conquered all passages!");
                    return;
                }

                typeInput.value = '';
                prevInputLength = 0;
                chaserIndex = -6;
                renderPassage(currentPassageIndex);
            }

            updateArenaScroll();
        });

        typeInput.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
            }
        });

        document.querySelector('.typing-arena').addEventListener('click', () => {
            if (!typeInput.disabled) typeInput.focus();
        });

        document.getElementById('btn-restart').addEventListener('click', () => location.reload());
        const modalRetry = document.getElementById('modal-btn-retry');
        if (modalRetry) modalRetry.addEventListener('click', () => location.reload());

        window.addEventListener('DOMContentLoaded', () => {
            startCountdown();
        });
    </script>
</body>

</html>