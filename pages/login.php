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
  <link rel="stylesheet" href="../css/login.css?v=<?php echo time(); ?>">
</head>

<body style="<?php echo $bg_style; ?>">

  <main class="auth-wrapper">
    <div class="auth-card auth-card-login">

      <div class="auth-panel auth-panel-left">
        <h2 class="form-heading">LOG IN</h2>

        <?php if (isset($_GET['timeout'])): ?>
          <div class="auth-alert alert-warning">
            Your session expired due to inactivity. Please log in again.
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="auth-alert alert-success">
            <?php
            echo htmlspecialchars($_SESSION['success']);
            unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="auth-alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
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
            <a href="../homepage.php" class="auth-btn btn-cancel">CANCEL</a>
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

</body>

</html>