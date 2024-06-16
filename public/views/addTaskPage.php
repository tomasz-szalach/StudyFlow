<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Add new task">
    <meta name="keywords" content="tasks, add, new">
    <title>StudyFlow - Add Task</title>
    <link rel="stylesheet" type="text/css" href="public/css/styleAddTaskPage.css">
</head>
<body>
    <div id="TopBar">
        <img class="logo" src="public/img/logo.svg" alt="Logo">
    </div>
    <div id="container-page">
        <main class="main-content">
            <div class="Page-Title-Bar">
                <span>Utwórz nowe zadanie</span>
            </div>
            <section class="add-task">
                <form action="addTask" method="POST">
                    <label for="task-name">Wpisz nazwę nowego zadania</label>
                    <input id="task-name" type="text" name="name" placeholder="Nazwa zadania" required>
                    <label for="task-desc">Wpisz opis zadania</label>
                    <textarea id="task-desc" name="description" placeholder="Opis zadania"></textarea>
                    <label for="task-date">Wybierz datę zakończenia zadania</label>
                    <input id="task-date" type="date" name="due_date" required>
                    <label for="task-list">Wybierz listę zadań</label>
                    <select id="task-list" name="task_list_id" required>
                        <?php foreach ($taskLists as $taskList): ?>
                            <option value="<?= $taskList['id'] ?>"><?= htmlspecialchars($taskList['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="buttons">
                        <button type="submit" class="add-button">Dodaj zadanie</button>
                        <a href="homePage" class="cancel-button">Anuluj</a>
                    </div>
                </form>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 StudyFlow</p>
    </footer>
    <script type="text/javascript" src="public/js/logout.js" defer></script>
</body>
</html>
