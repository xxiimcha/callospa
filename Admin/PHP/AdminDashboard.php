<?php
// Site metadata
$title = "Admin Dashboard - Callospa Resort";
$mainHeader = "Callospa Resort Admin Dashboard";
$loginTitle = "Admin Login";

// Check if there is an error message
$errorMessage = isset($_GET['error']) && $_GET['error'] === 'invalid_credentials' ? 'Invalid username or password.' : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="AdminDashboard.css" />
</head>

<body>
    <header class="header">
        <div class="header-content">
            <h1><?php echo htmlspecialchars($mainHeader, ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>
    </header>

    <main>
        <section class="login-section">
            <h2><?php echo htmlspecialchars($loginTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
            <?php if ($errorMessage): ?>
                <p class="error-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form action="AdminDashboardLogin.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required />

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />

                <button type="submit">Login</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Callospa Resort and Residences</p>
    </footer>
</body>

</html>