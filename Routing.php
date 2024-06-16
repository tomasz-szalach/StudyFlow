<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/TaskListController.php';

class Routing
{
    public static $routes = [];

    public static function get($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function run($url)
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $routeParts = explode('@', self::$routes[$action]);
        $controller = $routeParts[0];
        $method = $routeParts[1] ?? 'index';

        $object = new $controller;
        $object->$method();
    }
}

// Nowe trasy dla list zadań i zadań
Routing::get('homePage', 'TaskListController@homePage');
Routing::post('createTaskList', 'TaskListController@createTaskList');
Routing::post('deleteTaskList', 'TaskListController@deleteTaskList');
Routing::post('addTask', 'TaskListController@addTask');
Routing::get('addTaskPage', 'TaskListController@addTaskPage');
Routing::get('getTasks', 'TaskListController@getTasksByTaskList');
Routing::get('addTaskList', 'DefaultController@addTaskList');

// Pozostałe trasy
Routing::get('', 'DefaultController@index');
Routing::get('index', 'DefaultController@index');
Routing::get('registrationUser', 'SecurityController@registrationPage');
Routing::post('registrationUser', 'SecurityController@registrationUser');
Routing::post('login', 'SecurityController@login');
Routing::post('logout', 'SecurityController@logout');
Routing::post('searchTasks', 'TaskListController@searchTasks');
Routing::get('taskList', 'TaskListController@showTaskList');
Routing::post('updateTaskStatus', 'TaskListController@updateTaskStatus');
Routing::post('deleteTask', 'TaskListController@deleteTask');

// Trasa do zmiany hasła
Routing::get('changePasswordPage', 'SecurityController@changePasswordPage');
Routing::post('changePassword', 'SecurityController@changePassword');

// Trasy admina
Routing::get('adminHomePage', 'UserController@adminHomePage');
Routing::post('deleteUser', 'UserController@deleteUser');