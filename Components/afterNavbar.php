<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);

$navUsername    = $_SESSION['username'] ?? "TYPEMANIA";
$navCircleColor = $_SESSION['circle_color'] ?? "#00D4FF";
$navLetterColor = $_SESSION['letter_color'] ?? "#00D4FF";

$cleanNavName = trim($navUsername);
if (strlen($cleanNavName) >= 2) {
  $navInitials = strtoupper(substr($cleanNavName, 0, 2));
} elseif (strlen($cleanNavName) === 1) {
  $navInitials = strtoupper($cleanNavName) . "_";
} else {
  $navInitials = "TM";
}
?>

<link rel="stylesheet" href="../css/afterNavbar.css">
<link rel="stylesheet" href="../css/idleModal.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<header class="navbar-wrapper">
  <nav class="custom-navbar">

    <a href="../pages/homepageAfter.php" class="brand-logo">
      <span id="type">TYPE</span><span id="mania">MANIA</span>
    </a>

    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </label>

    <div class="nav-links">
      <a href="../pages/afterSignUp.php" class="nav-btn <?php echo ($currentPage == 'afterSignUp.php') ? 'active' : ''; ?>">HOME</a>
      <a href="../pages/play.php" class="nav-btn <?php echo ($currentPage == 'play.php') ? 'active' : ''; ?>">PLAY</a>
      <a href="../pages/ranks.php" class="nav-btn <?php echo ($currentPage == 'ranks.php') ? 'active' : ''; ?>">RANKS</a>
      <a href="../pages/stats.php" class="nav-btn <?php echo ($currentPage == 'stats.php') ? 'active' : ''; ?>">STATS</a>
    </div>

    <div class="navbar-actions" style="display: flex !important; flex-direction: row !important; align-items: center !important;">
      <a href="../pages/stats.php" class="nav-profile-link" style="display: inline-flex !important; flex-direction: row !important; align-items: center !important; gap: 12px !important; text-decoration: none !important; border: none !important; background: transparent !important; outline: none !important;">

        <span class="signup-text" style="text-decoration: none !important; color: #ffffff !important; font-family: 'Inter', sans-serif !important; font-size: 18px !important; font-weight: 600 !important; white-space: nowrap !important; margin: 0 !important; padding: 0 !important; display: inline-block !important; border: none !important; background: none !important; vertical-align: middle !important;">
          <?php echo htmlspecialchars($navUsername); ?>
        </span>

        <div class="nav-avatar-mini" style="width: 38px !important; height: 38px !important; min-width: 38px !important; min-height: 38px !important; max-width: 38px !important; max-height: 38px !important; border-radius: 50% !important; border: 2px solid <?php echo $navCircleColor; ?> !important; box-shadow: 0 0 10px <?php echo $navCircleColor; ?> !important; display: flex !important; align-items: center !important; justify-content: center !important; background-color: #0d0f14 !important; flex-shrink: 0 !important; box-sizing: border-box !important; overflow: hidden !important; text-decoration: none !important;">
          <span style="color: <?php echo $navLetterColor; ?> !important; font-family: 'Inter', sans-serif !important; font-weight: 800 !important; font-size: 13px !important; line-height: 1 !important; text-decoration: none !important; display: block !important; margin: 0 !important; padding: 0 !important; border: none !important; text-align: center !important; width: 100% !important;">
            <?php echo $navInitials; ?>
          </span>
        </div>

      </a>
    </div>

    <div id="idleModal" class="idle-modal d-none">
      <div class="idle-modal-content text-center p-4">
        <h4 class="mb-3">Are you still there?</h4>
        <p>You have been inactive. You will be logged out in <span id="idleCountdown">10</span> seconds.</p>
      </div>
    </div>

  </nav>

  <script>
        let warnTimer;
        let logoutTimer;
        let countdownInterval;
        let timeLeft = 10;

        const modal = document.getElementById('idleModal');
        const countdownEl = document.getElementById('idleCountdown');
        const stayBtn = document.getElementById('stayLoggedInBtn');

        function showWarning() {
            modal.classList.remove('d-none');
            timeLeft = 10;
            countdownEl.textContent = timeLeft;

            countdownInterval = setInterval(() => {
                timeLeft--;
                countdownEl.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);

            logoutTimer = setTimeout(() => {
                window.location.href = '../pages/login.php?timeout=1';
            }, 10000);
        }

        function resetTimers() {
            clearTimeout(warnTimer);
            clearTimeout(logoutTimer);
            clearInterval(countdownInterval);

            if (modal) modal.classList.add('d-none');

            warnTimer = setTimeout(showWarning, 20000);
        }

        ['mousemove', 'keydown', 'click', 'scroll'].forEach(evt => {
            window.addEventListener(evt, resetTimers);
        });

        if (stayBtn) {
            stayBtn.addEventListener('click', resetTimers);
        }

        resetTimers();
  </script>
</header>