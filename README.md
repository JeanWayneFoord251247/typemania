# ⌨️ TypeMania

> Where chaotic speed meets surgical precision — a real-time web-based competitive typing speed test platform.

---

## Features

* **Multiple Game Modes:**
  * **TypeRush:** Race against a countdown timer where accurate sentences award bonus survival time.
  * **TypeChase:** Stay ahead of a persistent color-tracking chaser with high WPM(Words per Minute) and precision.
  * **TypeRace:** Complete passages within a strict time to beat performance benchmarks.
* **Live Performance Metrics:** Real-time calculation of Words Per Minute (WPM), accuracy percentage, and dynamic streak multipliers.
* **Auto-Scrolling Typing Arena:** Active text cursor centering dynamically adjusts the view as passages wrap.
* **Global & Mode Leaderboards:** Track top scores, highest WPM, total words typed, and quickest run durations per mode with smooth scrolling views.
* **Custom Player Profiles:** User authentication and personalized player avatar circles and color themes.

---

## Tech Stack

* **Frontend:** HTML5, Vanilla CSS3, Vanilla JavaScript
* **Backend:** PHP
* **Database:** MySQL 
* **Architecture:** Session-based authentication, modular PHP components, and RESTful JSON score-saving endpoints.

---

## Project Structure

```text
typemania/
actions/              # PHP action scripts (saveScore, logout, auth handlers)
Assets/               # Custom fonts, icons, and images
Components/           # Reusable UI partials (navbars, modals, stat cards)
config/               # Database connection and environment config
css/                  # Custom modular stylesheets
js/                   # Dedicated client-side scripts
pages/                # Main application views (play, gameplay, ranks, stats)
homepage.php          # Landing page(before signup/login)
```

---

## Installation & Local Setup

### 1. Prerequisites

Ensure you have the following installed locally:

* **Web Server & Database:** [XAMPP](https://www.apachefriends.org/)
* **PHP:** PHP 8.0 or higher
* **Version Control:** [Git](https://git-scm.com/)
* **Web Browser:** Modern browser (Chrome, Edge, Firefox, Brave)

---

### 2. Clone the Repository

Clone the project into your local server web directory:

```bash
# For XAMPP on Windows
cd C:/xampp/htdocs

# For XAMPP on macOS / Linux
cd /Applications/XAMPP/xamppfiles/htdocs

# Clone the repository
git clone [https://github.com/your-username/typemania.git](https://github.com/your-username/typemania.git)
cd typemania
```

---

### 3. Database Setup

1. Start **Apache** and **MySQL** in your XAMPP Control Panel.
2. Open your browser and navigate to `http://localhost/phpmyadmin`.
3. Create a new database named `typemania_db`.
4. Select the newly created `typemania_db` database from the left sidebar.
5. Click on the **Import** tab in the top navigation bar.
6. Click **Choose File** and select your exported database file (e.g., `typemania_db.sql` or `database/schema.sql`).
7. Scroll to the bottom and click **Import** (or **Go**).

Alternatively, import via the command line:

```bash
# Windows / Mac / Linux MySQL CLI
mysql -u root -p typemania_db < database/typemania_db.sql
```

---

### 4. Configure Database Credentials

Ensure `config/config.php` matches your local MySQL setup:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'typemaniadb');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout_duration = 3600; 

if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }
    $_SESSION['last_activity'] = time();
}
```

---

### 5. Launch the Application

Navigate to the project root in your browser:

```text
http://localhost/typemania/homepage.php
```

---

## Security Practices

* **Prepared Statements:** Parameterized queries (`mysqli::prepare`) used across all authentication and leaderboard transactions to prevent SQL injection.
* **Input Sanitization:** Inbound payloads stripped of tags using `strip_tags()` with bounded length assertions.
* **Cryptographic Password Hashing:** Secure password verification and storage via `password_hash()` and `password_verify()` with `PASSWORD_DEFAULT`.
* **Session Protection:** Session regeneration on login/signup (`session_regenerate_id(true)`) to mitigate session fixation attacks.