<?php

class TaskRepository extends Repository
{
    // Dodawanie nowego zadania
    public function addTask($name, $description, $due_date, $status, $task_list_id, $user_id) {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stm = $pdo->prepare('INSERT INTO tasks (name, description, due_date, status, task_list_id, user_id) VALUES (?, ?, ?, ?, ?, ?)');
            $stm->execute([$name, $description, $due_date, $status, $task_list_id, $user_id]);

            if ($stm->rowCount() > 0) {
                $pdo->commit();
                return "Zadanie zostało dodane pomyślnie.";
            } else {
                $pdo->rollBack();
                throw new Exception('Nie udało się dodać zadania.');
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('Błąd podczas dodawania zadania: ' . $e->getMessage());
        }
    }

    // Pobieranie zadań dla użytkownika
    public function getTasksByUserId($user_id) {
        $pdo = $this->database->connect();
    
        try {
            $stm = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY id');
            $stm->execute([$user_id]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Błąd podczas pobierania zadań: ' . $e->getMessage());
        }
    }

    // Pobieranie zadań dla danej listy zadań
    public function getTasksByTaskList($listId, $userId) {
        $pdo = $this->database->connect();
    
        try {
            $stm = $pdo->prepare('SELECT * FROM tasks WHERE task_list_id = ? AND user_id = ? ORDER BY id');
            $stm->execute([$listId, $userId]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Błąd podczas pobierania zadań: ' . $e->getMessage());
        }
    }

    public function searchTasks($query, $taskListId, $userId)
    {
        $pdo = $this->database->connect();
    
        try {
            if (empty($query)) {
                $stm = $pdo->prepare('SELECT * FROM tasks WHERE task_list_id = ? AND user_id = ?');
                $stm->execute([$taskListId, $userId]);
            } else {
                $stm = $pdo->prepare('SELECT * FROM tasks WHERE (name ILIKE ? OR description ILIKE ?) AND task_list_id = ? AND user_id = ?');
                $searchQuery = '%' . $query . '%';
                $stm->execute([$searchQuery, $searchQuery, $taskListId, $userId]);
            }
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Błąd podczas wyszukiwania zadań: ' . $e->getMessage());
        }
    }
    
    
    public function getTaskById($taskId)
{
    $pdo = $this->database->connect();

    try {
        $stm = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stm->execute([$taskId]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Błąd podczas pobierania zadania: ' . $e->getMessage());
    }
}

public function updateTaskStatus($taskId, $status)
{
    $pdo = $this->database->connect();
    $pdo->beginTransaction();

    try {
        $stm = $pdo->prepare('UPDATE tasks SET status = ? WHERE id = ?');
        $stm->execute([$status, $taskId]);

        if ($stm->rowCount() > 0) {
            $pdo->commit();
        } else {
            $pdo->rollBack();
            throw new Exception('Nie udało się zaktualizować statusu zadania.');
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('Błąd podczas aktualizacji statusu zadania: ' . $e->getMessage());
    }
}

public function deleteTask($taskId)
{
    $pdo = $this->database->connect();
    $pdo->beginTransaction();

    try {
        $stm = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
        $stm->execute([$taskId]);

        if ($stm->rowCount() > 0) {
            $pdo->commit();
        } else {
            $pdo->rollBack();
            throw new Exception('Nie udało się usunąć zadania!');
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('Błąd podczas usuwania zadania: ' . $e->getMessage());
    }
}




    
}
