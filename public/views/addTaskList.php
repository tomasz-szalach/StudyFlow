<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Add a new task list">
        <meta name="keywords" content="tasks, todo, list">
        <title>StudyFlow - Add Task List</title>
        <link rel="stylesheet" type="text/css" href="public/css/styleRegistration.css">
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
                            <h1 class="SignUp-Title">Dodaj nową listę zadań</h1>
                            <form class="SignUp-form" action="createTaskList" method="POST">
                                <div class="messages">
                                    <?php
                                    if(isset($messages)){
                                        foreach ($messages as $message){
                                            echo $message;
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="Input-container">
                                    <input class="Input_input" type="text" name="name" placeholder="Nazwa listy zadań" required>
                                </div>
                                <div class="SignUp-formOptions">
                                    <button class="ButtonSignUp" type="submit">
                                        Dodaj listę
                                    </button>
                                    <div class="SignUp-optionlink">
                                        <a href="homePage">Powrót</a>
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
