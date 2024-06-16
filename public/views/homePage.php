<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Manage your tasks">
    <meta name="keywords" content="tasks, todo, list">
    <title>StudyFlow</title>
    <link rel="stylesheet" type="text/css" href="public/css/stylehomePage.css">
    <script type="text/javascript" src="public/js/logout.js" defer></script>
    <script type="text/javascript" src="public/js/search.js" defer></script>
    <script type="text/javascript" src="public/js/taskList.js" defer></script>
    <script type="text/javascript" src="public/js/changePassword.js" defer></script>
</head>
<body>
    <div id="TopBar">
        <img class="logo" src="public/img/logo.svg" alt="Logo">
        <div id="User-profile">
            <div class="User-profile2" onclick="logout(this)">
                <span class="Logout">Wyloguj się</span>
            </div>
            <div class="User-profile2" id="changePasswordButton">
                <span class="ChangePassword">Zmień hasło</span>
            </div>
        </div>
    </div>
    <div id="container-page">
        <aside class="sidebar">
            <div class="tasklist-display">
                <h3>Twoje listy zadań</h3>
                <?php if (!empty($taskLists)): ?>
                    <?php foreach ($taskLists as $index => $taskList): ?>
                        <div class="home-blocks">
                            <a class="TASKLIST <?= $index === 0 ? 'selected' : '' ?>" href="#" data-tasklist-id="<?= $taskList['id']; ?>">
                                <div class="TASKLIST-choose">
                                    <span class="tasklist-icon">&#x1F4CB;</span>
                                    <div class="name"> <?= htmlspecialchars($taskList['name']); ?> </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <a class="add-tasklist" href="addTaskList">Dodaj nową listę zadań</a>
            </div>
        </aside>
        <main class="main-content">
            <div class="Page-Title-Bar">
                <span class="page-title">Zadania <?php echo htmlspecialchars($taskLists[0]['name'] ?? ''); ?></span>
            </div>
            <div class="search-bar">
                <input id="search" placeholder="Znajdź zadanie">
                <span class="search-icon">&#128269;</span>
            </div>
            <a class="create-task-button" href="addTaskPage">Utwórz nowe zadanie</a>
            <section class="task-display">
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-item" data-task-id="<?= $task['id'] ?>">
                            <div class="task-header">
                                <input type="checkbox" class="task-checkbox" <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                                <div class="name <?= $task['status'] === 'completed' ? 'completed' : '' ?>"><?= htmlspecialchars($task['name']) ?></div>
                                <div class="due-date"><?= htmlspecialchars($task['due_date']) ?></div>
                                <div class="status"><?= htmlspecialchars($task['status'] === 'completed' ? 'Zakończone' : 'Do zrobienia') ?></div>
                                <button class="delete-task-button">🗑️</button>
                            </div>
                            <div class="description"><?= htmlspecialchars($task['description']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <template id="task-template">
        <div class="task-item" data-task-id="">
            <div class="task-header">
                <input type="checkbox" class="task-checkbox">
                <div class="name">Task Name</div>
                <div class="due-date">Due Date</div>
                <div class="status">Status</div>
                <button class="delete-task-button">🗑️</button>
            </div>
            <div class="description">Task Description</div>
        </div>
    </template>

    <footer>
        <p>&copy; 2024 StudyFlow</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskLists = document.querySelectorAll('.TASKLIST');
            const pageTitle = document.querySelector('.page-title');

            taskLists.forEach(taskList => {
                taskList.addEventListener('click', function () {
                    taskLists.forEach(tl => tl.classList.remove('selected'));
                    this.classList.add('selected');
                    const taskListName = this.querySelector('.name').textContent;
                    pageTitle.textContent = 'Zadania ' + taskListName;
                });
            });
        });
    </script>
</body>
</html>
