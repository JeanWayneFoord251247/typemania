<?php
require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['user_id'])) {
  header("Location: afterSignUp.php");
  exit();
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $identifier = trim($_POST['username'] ?? '');
  $password   = $_POST['password'] ?? '';

  if (empty($identifier) || empty($password)) {
    $error = "Please fill in all fields.";
  } else {
    $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
      if (password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']       = $user['user_id'];
        $_SESSION['username']      = $user['username'];
        $_SESSION['last_activity'] = time();

        header("Location: afterSignUp.php");
        exit();
      } else {
        $error = "Invalid credentials.";
      }
    } else {
      $error = "Invalid credentials.";
    }
    $stmt->close();
  }
}

$bg_style = "background: linear-gradient(115deg, #19EC06 0%, #00D4FF 35%, #ff9142 60%, #FFF700 100%);";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TypeMania - Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/login.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

  <main class="auth-wrapper">
    <div class="auth-card auth-card-login">

      <div class="auth-panel auth-panel-left">
        <h2 class="form-heading">LOG IN</h2>

        <?php if (isset($_GET['timeout'])): ?>
          <div class="alert alert-warning" style="background: rgba(255, 145, 66, 0.2); border: 1px solid #ff9142; color: #fff; border-radius: 12px; margin-bottom: 20px;">
            Your session expired due to inactivity. Please log in again.
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success" style="background: rgba(25, 236, 6, 0.15); border: 1px solid #19EC06; color: #fff; border-radius: 12px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']); ?>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-danger" style="background: rgba(255, 59, 48, 0.2); border: 1px solid #FF3B30; color: #fff; border-radius: 12px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form class="login-form" action="" method="POST">

          <div class="input-field">
            <input type="text" name="username" placeholder="USERNAME" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
          </div>

          <div class="input-field">
            <input type="password" name="password" placeholder="ENTER PASSWORD" required>
          </div>

          <div class="input-field">
            <input type="password" name="admin_pin" placeholder="ADMIN PIN">
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