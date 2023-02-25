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
                    <tr id='$student->_student_id'>
                        <td>$student->first_name</th>
                        <td>$student->second_name</td>
                        <td>$student->birth_date</td>
                        <td>$student->receipt_date</td>
                    </tr>
                ";
            }

            $res->setTitle('Студенты');
            $res->sendHTML("
                <table class='table table-dark table-hover'>
                    <thead>
                        <tr>
                            <th scope='col'>Имя</th>
                            <th scope='col'>Фамилия</th>
                            <th scope='col'>Дата рождения</th>
                            <th scope='col'>Дата поступления</th>
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
                <p class='font-monospace'>Студент {$student->second_name} {$student->first_name}</p>
            ");
        } else {
            $res->sendHTML("
                <p class='font-monospace'>Студент не найден</p>
            ", 404);
        }
    }
}
