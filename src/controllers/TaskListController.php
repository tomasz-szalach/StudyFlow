<?php

require_once 'SessionController.php';
require_once __DIR__.'/../repository/TaskListRepository.php';
require_once __DIR__.'/../repository/TaskRepository.php';

class TaskListController extends SessionController
{
    private $taskListRepository;
    private $taskRepository;

    public function __construct()
    {
        parent::__construct();
        $this->taskListRepository = new TaskListRepository();
        $this->taskRepository = new TaskRepository();
    }

    public function homePage()
    {
        $this->requiredSession();
        $taskLists = $this->taskListRepository->getAllTaskLists($this->getUserSessionId());
        $tasks = [];
    
        // Domyślnie załaduj pierwszą listę zadań
        if (!empty($taskLists)) {
            $firstTaskListId = $taskLists[0]['id'];
            $tasks = $this->taskRepository->getTasksByTaskList($firstTaskListId, $this->getUserSessionId());
        }
    
        $this->render('homePage', ['taskLists' => $taskLists, 'tasks' => $tasks]);
    }
    


    public function createTaskList()
    {
        $this->requiredSession();
        $name = $_POST['name'] ?? null;
        if ($name) {
            $this->taskListRepository->addTaskList($name, $this->getUserSessionId());
            $this->changeHeader('homePage');
        }
    }

    public function deleteTaskList()
    {
        $this->requiredSession();
        $listId = $_REQUEST['id'] ?? null;
        if ($listId) {
            $this->taskListRepository->deleteTaskList($listId);
            $this->changeHeader('homePage');
        }
    }

    public function addTask()
    {
        $this->requiredSession();
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $dueDate = $_POST['due_date'] ?? null;
        $taskListId = $_POST['task_list_id'] ?? null;
    
        if ($name && $dueDate && $taskListId) {
            $taskData = [
                'name' => $name,
                'description' => $description,
                'due_date' => $dueDate,
                'status' => 'to_do',
                'task_list_id' => $taskListId,
                'user_id' => $this->getUserSessionId()
            ];
            $this->taskRepository->addTask(
                $taskData['name'],
                $taskData['description'],
                $taskData['due_date'],
                $taskData['status'],
                $taskData['task_list_id'],
                $taskData['user_id']
            );
            $this->changeHeader('homePage');
        } else {
            error_log('Brakujące dane zadania: ' . print_r($_POST, true));
        }
    }

    public function getTasksByTaskList()
    {
        $this->requiredSession();
        $listId = $_REQUEST['id'] ?? null;
        if ($listId) {
            $tasks = $this->taskRepository->getTasksByTaskList($listId, $this->getUserSessionId());
            header('Content-Type: application/json');
            echo json_encode(['tasks' => $tasks]);
        }
    }

    public function searchTasks()
    {
        $this->requiredSession();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $query = $decoded['query'] ?? '';
            $taskListId = $decoded['task_list_id'] ?? '';

            if ($taskListId) {
                $tasks = $this->taskRepository->searchTasks($query, $taskListId, $this->getUserSessionId());
                header('Content-type: application/json');
                echo json_encode(['tasks' => $tasks]);
            } else {
                header('Content-type: application/json');
                echo json_encode(['tasks' => []]);
            }
        }
    }

    public function showTaskList() {
        $this->requiredSession();
        $listId = $_REQUEST['id'] ?? null;
        if ($listId) {
            $tasks = $this->taskRepository->getTasksByTaskList($listId, $this->getUserSessionId());
            $taskLists = $this->taskListRepository->getAllTaskLists($this->getUserSessionId());
            $this->render('homePage', ['taskLists' => $taskLists, 'tasks' => $tasks]);
        } else {
            $this->changeHeader('homePage');
        }
    }

    public function updateTaskStatus()
    {
        $this->requiredSession();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
    
            $taskId = $_REQUEST['id'] ?? null;
            $newStatus = $decoded['status'] ?? null;
    
            if ($taskId && $newStatus) {
                $this->taskRepository->updateTaskStatus($taskId, $newStatus);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function addTaskPage()
    {
        $this->requiredSession();
        $taskLists = $this->taskListRepository->getAllTaskLists($this->getUserSessionId());
        $this->render('addTaskPage', ['taskLists' => $taskLists]);
    }
    
    public function deleteTask()
    {
        $this->requiredSession();
        $taskId = $_REQUEST['id'] ?? null;
    
        if ($taskId) {
            $this->taskRepository->deleteTask($taskId);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    
}
