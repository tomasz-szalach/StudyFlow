<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../exceptions/NoMatchingRecordException.php';
require_once __DIR__.'/../exceptions/CannotAddRecordException.php';

class UserRepository extends Repository
{
    public function getUser(string $email): User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email);
        $stmt->execute();   

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            throw new NoMatchingRecordException();
        }

        return new User(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['role']
        );
    }

    public function saveUser(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (username, email, password, role)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        ]);
    }

    public function updatePassword(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE users SET password = :password WHERE id = :id
        ');
        $stmt->bindParam(':password', $user->getPassword());
        $stmt->bindParam(':id', $user->getId());
        $stmt->execute();
    }

    public function ifContains(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    
    public function deleteUser(int $id): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM users WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users
        ');
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
