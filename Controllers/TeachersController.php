<?php
class TeachersController
{
    public static function Teachers(Request $req, Response $res)
    {
        global $TeachersModel;

        $teachers = $TeachersModel->select()->leftJoin('gender', ['gender_id' => 'gender_id'])->eq()->requestAll();

        if ($teachers) {
            $teachersMarkup = '';

            foreach ($teachers as $teacher) {
                $teachersMarkup .= "
                    <tr id='$teacher->_teacher_id' onclick=window.location.href='teachers/$teacher->_teacher_id'>
                        <td>$teacher->first_name</th>
                        <td>$teacher->second_name</td>
                        <td>$teacher->middle_name</th>
                        <td>$teacher->age_num</td>
                        <td>$teacher->gender_name</td>
                    </tr>
                ";
            }

            $res->setTitle('Преподаватели');
            $res->sendHTML("
                <table class='table table-bordered table-hover caption-top'>
                    <caption class='fw-bold'>Список преподавателей</caption>
                    <thead>
                        <tr>
                            <th scope='col'>Имя</th>
                            <th scope='col'>Фамилия</th>
                            <th scope='col'>Отчество</th>
                            <th scope='col'>Возраст</th>
                            <th scope='col'>Пол</th>
                        </tr>
                    </thead>
                    <tbody class='font-monospace'>
                        $teachersMarkup
                    </tbody>
            ");
        }
    }

    public static function Teacher(Request $req, Response $res)
    {
        global $TeachersModel;

        $disciplines = 0;

        $res->setTitle('Список дисциплин');

        if ($disciplines) {
            $res->sendHTML("
                <div class='card border-warning font-monospace'>
                <div class='card-header text-center'>Список преподаваемых дисциплин</div>
                <div class='card-body'>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>Студент:</li>
                    </ul>
                </div>
            </div>
            ");
        } else {
            $res->sendHTML("
                <p class='font-monospace'>Дисциплины не найдены</p>
            ", 404);
        }
    }
}
