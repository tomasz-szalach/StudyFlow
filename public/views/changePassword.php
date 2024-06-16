<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Change Password">
    <meta name="keywords" content="change, password">
    <title>StudyFlow - Change Password</title>
    <link rel="stylesheet" type="text/css" href="public/css/styleChangePassword.css">
    <script type="text/javascript" src="public/js/logout.js" defer></script>
</head>
<body>
    <div id="TopBar">
        <img class="logo" src="public/img/logo.svg" alt="Logo">
        <div id="User-profile">
            <div class="User-profile2" onclick="logout(this)">
                <span class="Logout">Wyloguj się</span>
            </div>
        </div>
    </div>
    <div id="container-page">
        <main class="main-content">
            <div class="Page-Title-Bar">
                <span>Zmień hasło</span>
            </div>
            <section class="change-password">
                <form action="changePassword" method="POST">
                    <label for="old_pass">Obecne hasło</label>
                    <input id="old_pass" type="password" name="old_pass" placeholder="Obecne hasło" required>
                    <label for="new_pass">Nowe hasło</label>
                    <input id="new_pass" type="password" name="new_pass" placeholder="Nowe hasło" required>
                    <label for="new_pass2">Potwierdź nowe hasło</label>
                    <input id="new_pass2" type="password" name="new_pass2" placeholder="Potwierdź nowe hasło" required>
                    <div class="buttons">
                        <button type="submit" class="change-button">Zmień hasło</button>
                        <a href="homePage" class="cancel-button">Anuluj</a>
                    </div>
                </form>
                <?php if (isset($messages)): ?>
                    <div class="messages">
                        <?php foreach ($messages as $message): ?>
                            <p><?= htmlspecialchars($message) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 StudyFlow</p>
    </footer>
</body>
</html>
