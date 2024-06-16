<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Task Management">
        <meta name="keywords" content="tasks">
        <title>Task Manager - Home</title>
        <link rel="stylesheet" type="text/css" href="public/css/styletaskList.css">
        <script type="text/javascript" src="public/js/taskActions.js" defer></script>
    </head>
    <body>
        <div id="TopBar">
            <div id="User-profile">
                <div class="User-profile2" onclick="logout(this)">
                    <img class="User-profile-avatar" src="public/img/defaultAvatar.svg">
                    <span class="Logout">Logout</span>
                </div>
            </div>
        </div>
        <div class="Page-Title-Bar">
            <span>Task Manager</span>
        </div>
        <div id="container-page">
            <div class="task-list-blocks">
                <ul id="task-lists">
                    <?php foreach ($taskLists as $taskList): ?>
                        <li onclick="showTasks(<?php echo $taskList['id']; ?>)">
                            <?php echo htmlspecialchars($taskList['name']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button onclick="addTaskList()">Add Task List</button>
            </div>
            <div class="task-blocks">
                <ul id="tasks">
                </ul>
                <button onclick="addTask()">Add Task</button>
            </div>
        </div>
        <footer>
            <a class="ButtonBack" href="homePage">
                Back
            </a>
        </footer>
    </body>
</html>
