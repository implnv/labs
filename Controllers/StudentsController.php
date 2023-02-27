<?php
class StudentsController
{
    public static function Students(Request $req, Response $res)
    {
        global $StudentsModel;

        $students = $StudentsModel->select()->leftJoin('groups', ['group_id' => 'group_id'])->eq()->requestAll();

        if ($students) {
            $studentsMarkup = '';

            foreach ($students as $student) {
                $studentsMarkup .= "
                    <tr id='$student->_student_id' onclick=window.location.href='students/$student->_student_id'>
                        <td>$student->first_name</th>
                        <td>$student->second_name</td>
                        <td>$student->birth_date</td>
                        <td>$student->receipt_date</td>
                        <td>$student->group_name</td>
                    </tr>
                ";
            }

            $res->setTitle('Студенты');
            $res->sendHTML("
                <div class='btn-group' role='group' aria-label='Basic example'>
                    <button type='button' class='btn btn-primary'>Добавить</button>
                    <button type='button' class='btn btn-danger'>Удалить</button>
                    <button type='button' class='btn btn-warning'>Редактировать</button>
                </div>
                <table class='table table-bordered table-hover caption-top'>
                    <caption class='fw-bold'>Список студентов</caption>
                    <thead>
                        <tr>
                            <th scope='col'>Имя</th>
                            <th scope='col'>Фамилия</th>
                            <th scope='col'>Дата рождения</th>
                            <th scope='col'>Дата поступления</th>
                            <th scope='col'>Группа</th>
                        </tr>
                    </thead>
                    <tbody class='font-monospace'>
                        $studentsMarkup
                    </tbody>
            ");
        }
    }

    public static function Student(Request $req, Response $res)
    {
        global $StudentsModel;

        $student = $StudentsModel->select()->leftJoin('groups', ['group_id' => 'group_id'])->eq()->where(['student_id' => $req->params['id']])->request();

        $res->setTitle('Студент');

        if ($student) {
            $res->sendHTML("
                <div class='card border-warning font-monospace'>
                <div class='card-header text-center'>Карточка студента</div>
                <div class='card-body'>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>Студент: $student->first_name $student->second_name</li>
                        <li class='list-group-item'>Дата рождения: $student->birth_date</li>
                        <li class='list-group-item'>Дата поступления: $student->receipt_date</li>
                        <li class='list-group-item' onclick=window.location.href='/groups/$student->group_id' style='cursor: pointer;'>Группа: $student->group_name</li>
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
