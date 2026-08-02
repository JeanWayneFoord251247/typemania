<?php
$bg_style = "background: linear-gradient(115deg, #19EC06 0%, #00D4FF 35%, #F97316 60%, #FFF700 100%);";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TypeMania - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body style="<?php echo $bg_style; ?>">

  <main class="auth-wrapper">
    <div class="auth-card auth-card-login">

      <div class="auth-panel auth-panel-left">
        <h2 class="form-heading">LOG IN</h2>
        
        <form class="signup-form login-form" action="../pages/homepageAfter.php" method="POST">
          <div class="input-field">
            <input type="email" name="email" placeholder="EMAIL" required>
          </div>

          <div class="input-field">
            <input type="password" name="password" placeholder="ENTER PASSWORD" required>
          </div>

          <div class="input-field">
            <input type="password" name="admin_pin" placeholder="ADMIN PIN" required maxlength="6">
          </div>

          <div class="form-actions">
            <a href="../homepage.php" class="auth-btn btn-cancel text-center">CANCEL</a>
            <button type="submit" class="auth-btn btn-signup">LOG IN</button>
          </div>
        </form>
      </div>

      <div class="auth-panel auth-panel-right">
        <h1 class="welcome-heading">Welcome Back!</h1>
        <p class="welcome-text">
          Ready to test your typing speed? Log in to save your high scores, track your speed progression, and compete on the leaderboards. Don't have an account yet? Click below.
        </p>
        <a href="signUp.php" class="auth-btn btn-login">SIGN UP</a>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>