<?php
$mode = isset($_GET['mode']) ? strtolower($_GET['mode']) : 'rush';
$bg_style = "background: linear-gradient(115deg, #F97316 0%, #FFF700 35%, #19EC06 60%, #00D4FF 100%);";

$modeConfigs = [
    'rush' => [
        'border'  => '#19EC06',
        'glow'    => 'rgba(25, 236, 6, 0.4)',
        'bgGlow'  => 'rgba(25, 236, 6, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'QUICKEST', 'POINTS'],
        'data'    => [
            ['#1', 'SpeedDemon#99', '142', '0:24', '12,450'],
            ['#2', 'GhostRacer#01', '138', '0:26', '11,890'],
            ['#3', 'NeonTyper#44', '129', '0:28', '10,500'],
            ['#4', 'PixelStorm#88', '121', '0:31', '9,820'],
            ['#5', 'ShiftMaster#12', '115', '0:33', '9,100'],
        ],
        'userRank' => ['#42', 'Username#25648', '87', '0:41', '6,240']
    ],
    'chase' => [
        'border'  => '#FFF700',
        'glow'    => 'rgba(255, 247, 0, 0.4)',
        'bgGlow'  => 'rgba(255, 247, 0, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'POINTS', 'DISTANCE'],
        'data'    => [
            ['#1', 'ViperKey#07', '150', '15,200', '4,850m'],
            ['#2', 'TurboType#11', '141', '14,100', '4,320m'],
            ['#3', 'ChaserX#89', '135', '13,400', '3,990m'],
            ['#4', 'ShadowKeys#02', '128', '11,900', '3,650m'],
            ['#5', 'HyperShift#33', '120', '10,800', '3,100m'],
        ],
        'userRank' => ['#28', 'Username#25648', '95', '7,450', '2,150m']
    ],
    'race' => [
        'border'  => '#F97316',
        'glow'    => 'rgba(249, 115, 22, 0.4)',
        'bgGlow'  => 'rgba(249, 115, 22, 0.15)',
        'headers' => ['RANK', 'PLAYER', 'WPM', 'POINTS', 'FINISH TIME'],
        'data'    => [
            ['#1', 'NitroFinger#01', '165', '18,900', '0:45.12'],
            ['#2', 'ApexTyper#77', '158', '17,400', '0:48.30'],
            ['#3', 'PaceSetter#05', '149', '16,100', '0:51.04'],
            ['#4', 'Velocity#99', '140', '14,800', '0:55.80'],
            ['#5', 'CircuitKing#42', '132', '13,200', '0:59.10'],
        ],
        'userRank' => ['#54', 'Username#25648', '82', '5,800', '1:24.50']
    ]
];

$currentConfig = isset($modeConfigs[$mode]) ? $modeConfigs[$mode] : $modeConfigs['rush'];

$dynamicCardStyle = "style=\"border-color: {$currentConfig['border']}; box-shadow: 0 0 25px {$currentConfig['glow']};\"";
$dynamicTabsStyle = "style=\"border-color: {$currentConfig['border']}; box-shadow: 0 0 18px {$currentConfig['glow']};\"";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Leaderboards</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/ranks.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">

    <?php include '../Components/afterNavbar.php'; ?>

    <main class="ranks-container">
        
       <div class="mode-tabs-wrapper">
            <div class="mode-tabs" <?php echo $dynamicTabsStyle; ?>>
                <a href="ranks.php?mode=rush" class="tab-btn <?php echo $mode === 'rush' ? 'active' : ''; ?>" <?php echo $mode === 'rush' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'rush' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>RUSH</span></a>
                <a href="ranks.php?mode=chase" class="tab-btn <?php echo $mode === 'chase' ? 'active' : ''; ?>" <?php echo $mode === 'chase' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'chase' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>CHASE</span></a>
                <a href="ranks.php?mode=race" class="tab-btn <?php echo $mode === 'race' ? 'active' : ''; ?>" <?php echo $mode === 'race' ? "style=\"border: 2px solid {$currentConfig['border']}; box-shadow: 0 0 12px {$currentConfig['glow']}; background: {$currentConfig['bgGlow']};\"" : ''; ?>><span class="font-type">TYPE</span><span class="font-mode" <?php echo $mode === 'race' ? "style=\"color: {$currentConfig['border']};\"" : ''; ?>>RACE</span></a>
            </div>
        </div>

        <div class="leaderboard-card" <?php echo $dynamicCardStyle; ?>>
            
            <div class="leaderboard-header">
                <?php foreach ($currentConfig['headers'] as $header): ?>
                    <div class="col-item"><?php echo $header; ?></div>
                <?php endforeach; ?>
            </div>

            <div class="leaderboard-body">
                <?php foreach ($currentConfig['data'] as $row): ?>
                    <div class="leaderboard-row">
                        <div class="col-item"><?php echo $row[0]; ?></div>
                        <div class="col-item"><?php echo $row[1]; ?></div>
                        <div class="col-item"><?php echo $row[2]; ?></div>
                        <div class="col-item"><?php echo $row[3]; ?></div>
                        <div class="col-item"><?php echo $row[4]; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="personal-rank-card" <?php echo $dynamicCardStyle; ?>>
            <div class="col-item"><?php echo $currentConfig['userRank'][0]; ?></div>
            <div class="col-item">
                <?php echo $currentConfig['userRank'][1]; ?> 
                <span class="badge-you" style="color: <?php echo $currentConfig['border']; ?>;">(YOU)</span>
            </div>
            <div class="col-item"><?php echo $currentConfig['userRank'][2]; ?></div>
            <div class="col-item"><?php echo $currentConfig['userRank'][3]; ?></div>
            <div class="col-item"><?php echo $currentConfig['userRank'][4]; ?></div>
        </div>

    </main>

    <?php include '../Components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>