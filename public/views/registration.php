<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Zarejestruj się na StudyFlow">
    <meta name="keywords" content="rejestracja, konto, StudyFlow">
    <title>StudyFlow - Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="public/css/styleRegistration.css">
    <script type="text/javascript" src="public/js/togglePassword.js" defer></script>
</head>
<body>
    <div id="Page_topbar">
        <img class="Logo-small" src="public/img/logo.svg">
    </div>
    <div id="container">
        <div id="root">
            <div class="PageContainer">
                <section class="Registration-section">
                    <section class="ContainerBox">
                        <h1 class="SignUp-Title">Zarejestruj się</h1>
                        <form class="SignUp-form" action="registrationUser" method="POST">
                            <div class="messages">
                                <?php
                                if (isset($messages)) {
                                    foreach ($messages as $message) {
                                        echo $message;
                                    }
                                }
                                ?>
                            </div>
                            <div class="Input-container">
                                <input class="Input_input" type="text" name="username" placeholder="Nazwa użytkownika" required>
                            </div>
                            <div class="Input-container">
                                <input class="Input_input" type="text" name="email" placeholder="E-mail" required>
                            </div>
                            <div class="Input-container">
                                <input class="Input_input Input_input_password" type="password" name="password" placeholder="Hasło" required>
                            </div>
                            <div class="Input-container">
                                <input class="Input_input Input_input_password" type="password" name="password2" placeholder="Powtórz hasło" required>
                            </div>
                            <label class="SignUp-checkBox">
                                <input type="checkbox" onchange="togglePassword(this)">
                                <em>Pokaż hasło</em>
                            </label>
                            <div class="SignUp-formOptions">
                                <button class="ButtonSignUp" type="submit">Zarejestruj się</button>
                                <div class="SignUp-optionlink">
                                    <a href="login">Zaloguj się</a>
                                </div>
                            </div>
                        </form>
                    </section>
                    <img class="Login-logo" src="public/img/logo.svg">
                </section>
            </div>
        </div>
    </div>
</body>
</html>
