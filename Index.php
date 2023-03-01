<?php
require('Library/autoload.php');

Template::getInstance()->setHead('
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
');

Template::getInstance()->useWrapper('
    <div class="container mt-2 mb-2">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid p-0">
                <a class="navbar-brand rounded-2 p-1" style="background-color: #000000cf; color: #f9c000;" href="/">Администрирование</a>
                <div class="navbar-nav rounded-2" style="background-color: #f9c000; font-weight: 700;">
                    <a class="nav-link" href="/students" accesskey="1">Студенты</a>
                    <a class="nav-link" href="/groups" accesskey="2">Группы</a>
                    <a class="nav-link" href="/disciplines" accesskey="3">Дисциплины</a>
                    <a class="nav-link" href="/teachers" accesskey="4">Преподаватели</a>
                </div>
            </div>
        </nav>
    </div>
    <div id="root" class="container"></div>
', 'root');

$route = new Router();
$http  = new Http($route);

$StudentsModel              = new Model(StudentsModel::class);
$GroupsModel                = new Model(GroupsModel::class);
$DisciplinesModel           = new Model(DisciplinesModel::class);
$DisciplinesTeachersModel   = new Model(Disciplines_TeachersModel::class);
$TeachersModel              = new Model(TeachersModel::class);

$route->get('/', function (Request $req, Response $res) {
    $res->setTitle('Главная');
    $res->sendHTML('
        <div class="card border-warning font-monospace">
            <div class="card-header text-center">Заметка</div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Работа выполнена студентом группы АСУ-18-1БЗ Полуяновым Андреем. В данной работе реализованы CRUD операции, а также объектно-реляционное отображение <mark>при помощи собственной библиотеки.</p>
                </blockquote>
            </div>
        </div>
    ');
});

$route->get('/students', 'StudentsController::Students');
$route->get('/students/:id', 'StudentsController::Student');
$route->post('/students/add', 'StudentsController::StudentAdd');
$route->delete('/students/:id/remove', 'StudentsController::StudentRemove');
$route->patch('/students/:id/edit', 'StudentsController::StudentEdit');

$route->get('/groups', 'GroupsController::Groups');
$route->get('/groups/:id', 'GroupsController::Group');

$route->get('/disciplines', 'DisciplinesController::Disciplines');

$route->get('/teachers', 'TeachersController::Teachers');
$route->get('/teachers/:id', 'TeachersController::Teacher');

$http->listen();