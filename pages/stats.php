
<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit; // here i check if the user is logged in if not then the user is redirected to the login page and the rest of the page does not load, so basically a prevention system for non authenticated users.
}

$user_id = (int)$_SESSION['user_id']; // this just prevent any injections(no not vaccines or medicine), hacker/or very bored people that have nothing better to do then hack websites
$bg_style = "background: linear-gradient(115deg, #00D4FF 0%, #19EC06 35%, #FFF700 60%, #ff9142 100%);"; // this generates  a gradient background, just thought it could be cool in php.

$valid_circle_colors = ['#00D4FF', '#19EC06', '#FFF700', '#ff9142', '#A855F7', '#EC4899', '#EF4444', '#3B82F6', '#FFFFFF'];
$valid_letter_colors = ['#00D4FF', '#19EC06', '#FFF700', '#ff9142', '#A855F7', '#EC4899', '#EF4444', '#FFFFFF', '#12131A']; // both these inject colours into the website of which the user can each 1 colour from either option letter/circle for customization purposes

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //here i check to see if the page received a form submission via http post. In other words we are waiting for our takealot package.
    $new_username = isset($_POST['username']) ? substr(trim(strip_tags($_POST['username'])), 0, 16) : ''; //we are checking if our package actually arived with our exact order, then we strip any html and php tags to protect our code from injections and trim to remove any blank spaces and enforce a strict 16 character length
    $new_circle   = (isset($_POST['circle_color']) && in_array($_POST['circle_color'], $valid_circle_colors)) ? $_POST['circle_color'] : null;
    $new_letter   = (isset($_POST['letter_color']) && in_array($_POST['letter_color'], $valid_letter_colors)) ? $_POST['letter_color'] : null; //here we are just checking if the colours exist in our predefined array(line12-13) 

    if (!empty($new_username) || $new_circle || $new_letter) {
        $update_stmt = $conn->prepare("UPDATE users SET username = COALESCE(NULLIF(?, ''), username), circle_color = COALESCE(?, circle_color), letter_color = COALESCE(?, letter_color) WHERE user_id = ?");//-----here
        $update_stmt->bind_param("sssi", $new_username, $new_circle, $new_letter, $user_id); //here we are binding php variables to the query placeholders s stands for string and i is integer so for example $new_username wil be binded to string aswell as new circle and new letter and user_id will be binded to an integer
        $update_stmt->execute();
        $update_stmt->close();

        if (!empty($new_username)) $_SESSION['username'] = $new_username;
        if ($new_circle) $_SESSION['circle_color'] = $new_circle;
        if ($new_letter) $_SESSION['letter_color'] = $new_letter;
    }
}

$user_query = $conn->prepare("SELECT username, circle_color, letter_color FROM users WHERE user_id = ?");
$user_query->bind_param("i", $user_id); // same as line 22
$user_query->execute();
$user_data = $user_query->get_result()->fetch_assoc();
$user_query->close();

$username     = $user_data['username'] ?? $_SESSION['username'] ?? "TYPEMANIA";
$circle_color = $user_data['circle_color'] ?? $_SESSION['circle_color'] ?? "#00D4FF";
$letter_color = $user_data['letter_color'] ?? $_SESSION['letter_color'] ?? "#00D4FF";

$clean_name = trim($username);
if (strlen($clean_name) >= 2) {
    $avatar_initials = strtoupper(substr($clean_name, 0, 2));
} elseif (strlen($clean_name) === 1) {
    $avatar_initials = strtoupper($clean_name) . "_";
} else {
    $avatar_initials = "TM";
}

$global_stats_stmt = $conn->prepare("
    SELECT 
        COALESCE(MAX(wpm), 0) AS max_wpm,
        COALESCE(ROUND(AVG(wpm), 0), 0) AS avg_wpm,
        COALESCE(ROUND(AVG(accuracy), 1), 100.0) AS avg_acc,
        COUNT(score_id) AS total_games
    FROM game_scores 
    WHERE user_id = ?
");
$global_stats_stmt->bind_param("i", $user_id);
$global_stats_stmt->execute();
$global_stats = $global_stats_stmt->get_result()->fetch_assoc();
$global_stats_stmt->close(); //from line 51 to 63 we query aggregated metrics specifically for the logged-in user and fetches them as globa_stats

$rank_query = $conn->query("
    SELECT user_id, MAX(points) AS top_score 
    FROM game_scores 
    GROUP BY user_id 
    ORDER BY top_score DESC
"); // executes a direct SQL query returing the users top stats 

$player_rank = "N/A";
if ($rank_query) {
    $pos = 1;
    while ($row = $rank_query->fetch_assoc()) {
        if ((int)$row['user_id'] === $user_id) {
            $player_rank = "#" . $pos;
            break;
        }
        $pos++;
    }
}

$mode_stats_stmt = $conn->prepare("
    SELECT 
        mode_id,
        COALESCE(MAX(wpm), 0) AS best_wpm,
        COALESCE(MIN(duration_seconds), 0) AS quickest_time,
        COALESCE(MAX(words_typed), 0) AS max_words
    FROM game_scores 
    WHERE user_id = ? 
    GROUP BY mode_id
");
$mode_stats_stmt->bind_param("i", $user_id);
$mode_stats_stmt->execute();
$mode_result = $mode_stats_stmt->get_result();

$modes_data = [
    1 => ['best_wpm' => 0, 'quickest_time' => 0, 'max_words' => 0],
    2 => ['best_wpm' => 0, 'quickest_time' => 0, 'max_words' => 0],
    3 => ['best_wpm' => 0, 'quickest_time' => 0, 'max_words' => 0]
];

while ($m = $mode_result->fetch_assoc()) {
    $modes_data[$m['mode_id']] = $m;
}
$mode_stats_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Player Stats</title>

    <link rel="stylesheet" href="../css/stats.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/customiseModal.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="stats-wrapper">
        <div class="stats-card">

            <div class="stats-header">
                <div class="avatar-container" title="Click to edit profile">
                    <div class="avatar-box" style="border-color: <?php echo $circle_color; ?>; box-shadow: 0 0 18px <?php echo $circle_color; ?>;">
                        <span style="color: <?php echo $letter_color; ?>;"><?php echo $avatar_initials; ?></span>
                    </div>
                </div>

                <div class="user-details">
                    <div class="name-edit-row">
                        <h1 class="player-name"><?php echo htmlspecialchars($username); ?></h1>
                        <button type="button" class="btn-edit-profile">EDIT PROFILE</button>
                    </div>
                    <span class="player-rank-badge">RANK <?php echo $player_rank; ?></span>
                </div>
            </div>

            <hr class="stats-divider">

            <div class="metrics-grid">
                <div class="metric-box box-cyan">
                    <span class="metric-label">HIGHEST WPM</span>
                    <span class="metric-value"><?php echo $global_stats['max_wpm']; ?></span>
                </div>
                <div class="metric-box box-green">
                    <span class="metric-label">AVERAGE WPM</span>
                    <span class="metric-value"><?php echo $global_stats['avg_wpm']; ?></span>
                </div>
                <div class="metric-box box-yellow">
                    <span class="metric-label">ACCURACY</span>
                    <span class="metric-value"><?php echo $global_stats['avg_acc']; ?>%</span>
                </div>
                <div class="metric-box box-orange">
                    <span class="metric-label">TOTAL TESTS</span>
                    <span class="metric-value"><?php echo $global_stats['total_games']; ?></span>
                </div>
            </div>

            <div class="mode-breakdown">
                <h2 class="section-title">MODE PERFORMANCE</h2>

                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-green">TYPERUSH</span>
                        <span class="mode-stat">Words Typed: <?php echo number_format($modes_data[1]['max_words']); ?></span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> <?php echo $modes_data[1]['best_wpm']; ?> WPM
                    </div>
                </div>

                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-yellow">TYPECHASE</span>
                        <span class="mode-stat">Words Typed: <?php echo number_format($modes_data[2]['max_words']); ?></span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> <?php echo $modes_data[2]['best_wpm']; ?> WPM
                    </div>
                </div>

                <div class="mode-row">
                    <div class="mode-info">
                        <span class="mode-name name-orange">TYPERACE</span>
                        <span class="mode-stat">Best Time: <?php echo gmdate("i:s", $modes_data[3]['quickest_time']); ?></span>
                    </div>
                    <div class="mode-score">
                        <span class="score-label">BEST:</span> <?php echo $modes_data[3]['best_wpm']; ?> WPM
                    </div>
                </div>
            </div>

            <div class="stats-actions">
                <a href="play.php" class="stats-btn btn-play">PLAY AGAIN</a>
                <a href="ranks.php" class="stats-btn btn-ranks">LEADERBOARDS</a>
                <a href="../actions/logout.php" class="stats-btn btn-logout">LOGOUT</a>
            </div>

        </div>
    </main>

    <?php include '../Components/customiseModal.php'; ?>

    <?php include '../Components/footer.php'; ?>

    <script src="../js/stats.js?v=<?php echo time(); ?>" defer></script>
</body>

</html>