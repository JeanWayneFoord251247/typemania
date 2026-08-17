<?php
$bg_style = "background: linear-gradient(115deg, #FFF700 0%, #ff9142 35%, #00D4FF 60%, #19EC06 100%);";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Sign Up</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/signUp.css?v=<?php echo time(); ?>">
</head>
<body style="<?php echo $bg_style; ?>">

  <main class="auth-wrapper">
    <div class="auth-card">

      <div class="auth-panel auth-panel-left">
        <h1 class="welcome-heading">Welcome!</h1>
        <p class="welcome-text">
          Please enter your details, so that we can save your typing scores and track your speed. Already have a profile? Click Below.
        </p>
        <a href="login.php" class="auth-btn btn-login">LOG IN</a>
      </div>

      <div class="auth-panel auth-panel-right">
        <h2 class="form-heading">SIGN UP</h2>
        
        <form class="signup-form" action="../pages/homepageAfter.php" method="POST">
          <div class="input-field">
            <input type="email" name="email" placeholder="EMAIL" required>
          </div>

          <div class="input-field">
            <input type="password" name="password" placeholder="ENTER PASSWORD" required>
          </div>

          <div class="input-field">
            <input type="password" name="confirm_password" placeholder="RE-ENTER PASSWORD" required>
          </div>

          <div class="input-field">
            <input type="password" name="admin_pin" placeholder="ADMIN PIN" required maxlength="6">
          </div>

          <div class="form-actions">
            <a href="../homepage.php" class="auth-btn btn-cancel text-center">CANCEL</a>
            <button type="submit" class="auth-btn btn-signup">SIGN UP</button>
          </div>
        </form>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>