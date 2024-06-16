<?php

ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log'); // Ścieżka do pliku logów w kontenerze Docker

require_once 'SessionController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../exceptions/NoMatchingRecordException.php';
require_once __DIR__.'/../exceptions/CannotAddRecordException.php';

class SecurityController extends SessionController
{
    public function login()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }
        if (!$this->areAllSet(['email', 'password'])) {
            return $this->render('login', ['messages' => ['Brakujące dane']]);
        }

        $email = $_POST['email'];
        $pass = $_POST['password'];

        try {
            $user = $userRepository->getUser($email);
        } catch (NoMatchingRecordException $e) {
            return $this->render('login', ['messages' => ["Użytkownik nie istnieje"]]);
        }

        if (!password_verify($pass, $user->getPassword())) {
            return $this->render('login', ['messages' => ["Nieprawidłowe hasło"]]);
        }

        $this->createSession($user);

        $this->changeHeader('homePage');
    }

    public function registrationUser()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('registration');
        }

        if (!$this->areAllSet(['username', 'email', 'password', 'password2'])) {
            return $this->render('registration', ['messages' => ['Brakujące dane']]);
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        // Sprawdzanie poprawności adresu e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('registration', ['messages' => ['Nieprawidłowy adres e-mail']]);
        }

        if ($password !== $password2) {
            return $this->render('registration', ['messages' => ['Hasła nie są zgodne']]);
        }

        if (!$this->validatePassword($password)) {
            return $this->render('registration', ['messages' => ['Nowe hasło jest za słabe']]);
        }

        // Sprawdź, czy użytkownik już istnieje
        try {
            $existingUser = $userRepository->getUser($email);
            return $this->render('registration', ['messages' => ['Użytkownik o tym e-mail już istnieje']]);
        } catch (NoMatchingRecordException $e) {
            // Kontynuujemy rejestrację, ponieważ użytkownik nie istnieje
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $user = new User(null, $username, $email, $hash, 'user');

        try {
            $userRepository->saveUser($user);
            return $this->render('login', ['messages' => ['Konto zostało utworzone']]);
        } catch (Exception $e) {
            error_log('Registration error: ' . $e->getMessage());
            return $this->render('registration', ['messages' => ['Nie udało się utworzyć konta']]);
        }
    }

    public function changePasswordPage() {
        $this->render('changePassword');
    }

    public function changePassword() {
        $this->requiredSession();
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('changePassword');
        }

        if (!$this->areAllSet(['old_pass', 'new_pass', 'new_pass2'])) {
            return $this->render('changePassword', ['messages' => ['Brakujące dane']]);
        }

        $oldPassword = $_POST['old_pass'];
        $newPassword = $_POST['new_pass'];
        $newPassword2 = $_POST['new_pass2'];

        if (!$this->validatePassword($newPassword)) {
            return $this->render('changePassword', ['messages' => ['Nowe hasło jest za słabe']]);
        }

        if ($newPassword !== $newPassword2) {
            return $this->render('changePassword', ['messages' => ['Hasła nie są zgodne']]);
        }

        if ($oldPassword === $newPassword) {
            return $this->render('changePassword', ['messages' => ['Nowe hasło musi być inne niż stare hasło']]);
        }

        $result = $this->getUserSession();
        $user = $result['user'];

        if (!password_verify($oldPassword, $user->getPassword())) {
            return $this->render('changePassword', ['messages' => ['Stare hasło jest nieprawidłowe']]);
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $user->setPassword($hash);

        try {
            $userRepository->updatePassword($user);
            return $this->render('changePassword', ['messages' => ['Hasło zostało zmienione!']]);
        } catch (Exception $e) {
            return $this->render('changePassword', ['messages' => ['Nie udało się zmienić hasła']]);
        }
    }

    public function logout() {
        session_destroy();
        $this->changeHeader("login");
    }

    public function validatePassword(string $password): bool {
        if (strlen($password) < 8) {
            return false;
        }

        return true;
    }
   

}
