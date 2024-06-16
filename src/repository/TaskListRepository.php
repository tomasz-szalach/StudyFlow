<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/TaskList.php';

class TaskListRepository extends Repository
{
    // Dodawanie listy zadań
    public function addTaskList($name, $userId) {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stm = $pdo->prepare('INSERT INTO task_lists (name, user_id) VALUES (?, ?)');
            $stm->execute([$name, $userId]);

            if ($stm->rowCount() > 0) {
                $pdo->commit();
                return "Lista zadań została dodana pomyślnie.";
            } else {
                $pdo->rollBack();
                throw new Exception('Nie udało się dodać listy zadań.');
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('Błąd podczas dodawania listy zadań: ' . $e->getMessage());
        }
    }

    // Pobieranie wszystkich list zadań użytkownika
    public function getAllTaskLists($userId) {
        $pdo = $this->database->connect();

        try {
            $stm = $pdo->prepare('SELECT * FROM task_lists WHERE user_id = ?');
            $stm->execute([$userId]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Błąd podczas pobierania list zadań: ' . $e->getMessage());
        }
    }

    // Aktualizacja nazwy listy zadań
    public function updateTaskListName($listId, $newName) {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stm = $pdo->prepare('UPDATE task_lists SET name = ? WHERE id = ?');
            $stm->execute([$newName, $listId]);

            if ($stm->rowCount() > 0) {
                $pdo->commit();
                return "Nazwa listy zadań została zaktualizowana pomyślnie.";
            } else {
                $pdo->rollBack();
                throw new Exception('Nie udało się zaktualizować nazwy listy zadań.');
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('Błąd podczas aktualizacji nazwy listy zadań: ' . $e->getMessage());
        }
    }

    // Usuwanie listy zadań
    public function deleteTaskList($listId) {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stm = $pdo->prepare('DELETE FROM task_lists WHERE id = ?');
            $stm->execute([$listId]);

            if ($stm->rowCount() > 0) {
                $pdo->commit();
                return "Lista zadań została usunięta pomyślnie.";
            } else {
                $pdo->rollBack();
                throw new Exception('Nie udało się usunąć listy zadań.');
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('Błąd podczas usuwania listy zadań: ' . $e->getMessage());
        }
    }

    
}
