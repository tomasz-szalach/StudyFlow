<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController@index');
Routing::get('index', 'DefaultController@index');
Routing::get('homePage', 'TaskListController@homePage');
Routing::post('createTaskList', 'TaskListController@createTaskList');
Routing::post('deleteTaskList', 'TaskListController@deleteTaskList');
Routing::post('addTask', 'TaskListController@addTask');
Routing::get('getTasks', 'TaskListController@getTasksByTaskList');

// Pozostałe trasy
Routing::post('login', 'SecurityController@login');
Routing::post('logout', 'SecurityController@logout');
Routing::post('registrationUser', 'SecurityController@registrationUser');

Routing::run($path);
