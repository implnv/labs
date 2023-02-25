<?php
class StudentsController
{
    public static function Students(Request $req, Response $res)
    {
        global $StudentsModel;

        $students = $StudentsModel->find([]);
        
        if ($students) {
            $s = '';

            foreach ($students as $student) {
                $s .= "
                    <tr id='$student->_student_id' onclick=window.location.href='students/$student->_student_id'>
                        <td>$student->first_name</th>
                        <td>$student->second_name</td>
                        <td>$student->birth_date</td>
                        <td>$student->receipt_date</td>
                        <td>$student->group_id</td>
                    </tr>
                ";
            }

            $res->setTitle('Студенты');
            $res->sendHTML("
                <table class='table table-hover caption-top'>
                    <caption class=''>Список студентов</caption>
                    <thead>
                        <tr>
                            <th scope='col'>Имя</th>
                            <th scope='col'>Фамилия</th>
                            <th scope='col'>Дата рождения</th>
                            <th scope='col'>Дата поступления</th>
                            <th scope='col'>Группа</th>
                        </tr>
                    </thead>
                    <tbody>
                        $s
                    </tbody>
            ");
        }
    }

    public static function Student(Request $req, Response $res)
    {
        global $StudentsModel;
        $student = $StudentsModel->findById($req->params['id']);

        $res->setTitle('Студент');

        if ($student) {
            $res->sendHTML("
                <div class='card border-primary-subtle font-monospace'>
                <div class='card-header text-center'>Карточка студента</div>
                <div class='card-body'>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>$student->first_name $student->second_name</li>
                        <li class='list-group-item'>Дата рождения: $student->birth_date</li>
                        <li class='list-group-item'>Дата поступления: $student->receipt_date</li>
                    </ul>
                </div>
            </div>
            ");
        } else {
            $res->sendHTML("
                <p class='font-monospace'>Студент не найден</p>
            ", 404);
        }
    }
}
