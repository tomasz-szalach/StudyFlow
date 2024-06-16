<?php

require_once 'SessionController.php';
require_once __DIR__.'/../repository/TaskListRepository.php';

class TaskListController extends SessionController
{
    private $taskListRepository;

    public function __construct()
    {
        parent::__construct();
        $this->taskListRepository = new TaskListRepository();
    }

    public function homePage(){
        $this->requiredSession();
        $taskLists = $this->taskListRepository->getAllTaskLists($this->getUserSessionId());
        $this->render('homePage', ['taskLists' => $taskLists]);
    }

    public function createTaskList(){
        $this->requiredSession();
        $name = $_POST['name'] ?? null;
        if ($name) {
            $this->taskListRepository->addTaskList($name, $this->getUserSessionId());
            $this->changeHeader('homePage');
        }
    }

    public function deleteTaskList(){
        $this->requiredSession();
        $listId = $_REQUEST['id'] ?? null;
        if ($listId) {
            $this->taskListRepository->deleteTaskList($listId);
            $this->changeHeader('homePage');
        }
    }
}
