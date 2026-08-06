<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #F97316 100%);";

$username     = $_SESSION['username'] ?? "TYPEMANIA";
$circle_color = $_SESSION['circle_color'] ?? "#00D4FF";
$letter_color = $_SESSION['letter_color'] ?? "#00D4FF";

$valid_circle_colors = [
    '#00D4FF', '#19EC06', '#FFF700', '#F97316', 
    '#A855F7', '#EC4899', '#EF4444', '#3B82F6', '#FFFFFF'
];

$valid_letter_colors = [
    '#00D4FF', '#19EC06', '#FFF700', '#F97316', 
    '#A855F7', '#EC4899', '#EF4444', '#FFFFFF', '#12131A'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $username = substr(trim(strip_tags($_POST['username'])), 0, 16);
        $_SESSION['username'] = $username;
    }
    
    if (isset($_POST['circle_color']) && in_array($_POST['circle_color'], $valid_circle_colors)) {
        $circle_color = $_POST['circle_color'];
        $_SESSION['circle_color'] = $circle_color;
    }
    
    if (isset($_POST['letter_color']) && in_array($_POST['letter_color'], $valid_letter_colors)) {
        $letter_color = $_POST['letter_color'];
        $_SESSION['letter_color'] = $letter_color;
    }
}

$clean_name = trim($username);
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
    <title>TypeMania - Player Stats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stats.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="stats-wrapper">
        <div class="stats-card">

            <div class="stats-header">
                <div class="avatar-container" data-bs-toggle="modal" data-bs-target="#customizeProfileModal" title="Click to edit profile">
                    <div class="avatar-box" style="border-color: <?php echo $circle_color; ?>; box-shadow: 0 0 18px <?php echo $circle_color; ?>;">
                        <span style="color: <?php echo $letter_color; ?>;"><?php echo $avatar_initials; ?></span>
                    </div>
                    <div class="avatar-edit-badge">🖋️</div>
                </div>

                <div class="user-details">
                    <div class="name-edit-row">
                        <h1 class="player-name"><?php echo htmlspecialchars($username); ?></h1>
                        <button type="button" class="btn-edit-profile" data-bs-toggle="modal" data-bs-target="#customizeProfileModal">EDIT PROFILE</button>
                    </div>
                    <span class="player-rank-badge">RANK #42</span>
                </div>
            </div>

            <hr class="stats-divider">

            <div class="metrics-grid">
                <div class="metric-box box-cyan">
                    <span class="metric-label">HIGHEST WPM</span>
                    <span class="metric-value">124</span>
                </div>
                <div class="metric-box box-green">
                    <span class="metric-label">AVERAGE WPM</span>
                    <span class="metric-value">87</span>
                </div>
                <div class="metric-box box-yellow">
                    <span class="metric-label">ACCURACY</span>
                    <span class="metric-value">98.4%</span>
                </div>
                <div class="metric-box box-orange">
                    <span class="metric-label">TOTAL TESTS</span>
                    <span class="metric-value">342</span>
                </div>
            </div>

            <div class="mode-breakdown">
                <h2 class="section-title">MODE PERFORMANCE</h2>
                
                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-green">TYPERUSH</span>
                        <span class="mode-stat">Quickest: 0:24</span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> 142 WPM
                    </div>
                </div>

                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-yellow">TYPECHASE</span>
                        <span class="mode-stat">Max Dist: 2,150m</span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> 95 WPM
                    </div>
                </div>

                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-orange">TYPERACE</span>
                        <span class="mode-stat">Best Time: 1:24.50</span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> 82 WPM
                    </div>
                </div>
            </div>

            <div class="stats-actions">
                <a href="play.php" class="stats-btn btn-play">PLAY AGAIN</a>
                <a href="../ranks.php" class="stats-btn btn-ranks">LEADERBOARDS</a>
            </div>

        </div>
    </main>

    <div class="modal fade" id="customizeProfileModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-glitch" id="modalLabel">CUSTOMIZE PROFILE</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="modal-body">

                        <div class="modal-preview-wrapper mb-4 text-center">
                            <span class="modal-label d-block mb-2">LIVE PREVIEW</span>
                            <div class="avatar-box mx-auto" id="previewCircle" style="border-color: <?php echo $circle_color; ?>; box-shadow: 0 0 18px <?php echo $circle_color; ?>;">
                                <span id="previewText" style="color: <?php echo $letter_color; ?>;"><?php echo $avatar_initials; ?></span>
                            </div>
                        </div>

                        <div class="modal-group">
                            <label for="usernameInput" class="modal-label">USERNAME</label>
                            <input type="text" id="usernameInput" name="username" class="custom-input" value="<?php echo htmlspecialchars($username); ?>" maxlength="16" required placeholder="ENTER USERNAME">
                        </div>

                        <div class="modal-group">
                            <label class="modal-label">CIRCLE BORDER COLOR</label>
                            <div class="color-palette">
                                <?php foreach ($valid_circle_colors as $color): ?>
                                    <label class="color-swatch-label">
                                        <input type="radio" name="circle_color" value="<?php echo $color; ?>" <?php echo ($circle_color === $color) ? 'checked' : ''; ?>>
                                        <span class="color-swatch" style="background-color: <?php echo $color; ?>;"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="modal-group">
                            <label class="modal-label">LETTER COLOR</label>
                            <div class="color-palette">
                                <?php foreach ($valid_letter_colors as $color): ?>
                                    <label class="color-swatch-label">
                                        <input type="radio" name="letter_color" value="<?php echo $color; ?>" <?php echo ($letter_color === $color) ? 'checked' : ''; ?>>
                                        <span class="color-swatch" style="background-color: <?php echo $color; ?>;"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="stats-btn btn-cancel-modal" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="stats-btn btn-save-modal">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../Components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const usernameInput = document.getElementById('usernameInput');
        const previewCircle = document.getElementById('previewCircle');
        const previewText   = document.getElementById('previewText');

        usernameInput?.addEventListener('input', (e) => {
            const val = e.target.value.trim();
            if (val.length >= 2) previewText.textContent = val.substring(0, 2).toUpperCase();
            else if (val.length === 1) previewText.textContent = val.substring(0, 1).toUpperCase() + '_';
            else previewText.textContent = 'TM';
        });

        document.querySelectorAll('input[name="circle_color"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                previewCircle.style.borderColor = e.target.value;
                previewCircle.style.boxShadow = `0 0 18px ${e.target.value}`;
            });
        });

        document.querySelectorAll('input[name="letter_color"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                previewText.style.color = e.target.value;
            });
        });
    });
    </script>
</body>
</html>