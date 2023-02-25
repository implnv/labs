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
        <nav class="navbar navbar-expand-lg rounded-4  font-monospace" style="background-color: #0000000f">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Администрирование</a>
                <div class="navbar-nav">
                    <a class="nav-link" href="/students">Студенты</a>
                    <a class="nav-link" href="/groups">Группы</a>
                    <a class="nav-link" href="#">Дисциплины</a>
                    <a class="nav-link" href="#">Ведомость</a>
                    <a class="nav-link" href="#"">Преподаватели</a>
                </div>
            </div>
        </nav>
    </div>
    <div id="root" class="container"></div>
');

$route = new Router();
$http = new Http($route);

$StudentsModel = new Model(StudentsModel::class);
$groupsModel   = new Model(GroupsModel::class);

$route->get('/', function (Request $req, Response $res) {
    $res->setTitle('Главная');
    $res->sendHTML('
        <div class="card border-primary-subtle font-monospace">
            <div class="card-header text-center">Заметка</div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                <p>Работа выполнена Полуяновым Андреем, группа АСУ-18-1БЗ. В данной работе реализованы CRUD операции, а также объектно-реляционное отображение <mark>при помощи собственной библиотеки:</mark> <a href="https://github.com/implnv/moco">https://github.com/implnv/moco</a></p>
                </blockquote>
            </div>
        </div>
    ');
});

$route->get('/students', 'StudentsController::Students');
$route->get('/students/:id', 'StudentsController::Student');

$route->get('/groups', 'GroupsController::Groups');

$http->listen();