<?php
require_once __DIR__ . '/../config/config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare insert into exact database columns
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                session_regenerate_id(true);
                $_SESSION['user_id']  = $conn->insert_id;
                $_SESSION['username'] = $username;
                $_SESSION['last_activity'] = time();

                header("Location: afterSignUp.php");
                exit();
            } else {
                if ($conn->errno === 1062) {
                    $errors[] = "Username is already taken.";
                } else {
                    $errors[] = "Registration failed: " . $stmt->error;
                }
            }
            $stmt->close();
        } else {
            $errors[] = "Database query error: " . $conn->error;
        }
    }
}

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

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger" style="background: rgba(255, 59, 48, 0.2); border: 1px solid #FF3B30; color: #fff; border-radius: 12px; margin-bottom: 20px;">
            <?php foreach ($errors as $err): ?>
              <p class="m-0">• <?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form class="signup-form" action="" method="POST">
          <div class="input-field">
            <input type="text" name="username" placeholder="USERNAME" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
          </div>

          <div class="input-field">
            <input type="password" name="password" placeholder="ENTER PASSWORD" required>
          </div>

          <div class="input-field">
            <input type="password" name="confirm_password" placeholder="RE-ENTER PASSWORD" required>
          </div>

          <div class="form-actions">
            <a href="../pages/afterSignUp.php" class="auth-btn btn-cancel text-center">CANCEL</a>
            <button type="submit" class="auth-btn btn-signup">SIGN UP</button>
          </div>
        </form>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>