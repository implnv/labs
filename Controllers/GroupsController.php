<?php
class GroupsController
{
    public static function Groups(Request $req, Response $res)
    {
        global $GroupsModel;

        $groups = $GroupsModel->find([]);

        if ($groups) {
            $groupsMarkup = '';

            foreach ($groups as $group) {
                $groupsMarkup .= "
                    <tr id='$group->_group_id' onclick=window.location.href='groups/$group->_group_id'>
                        <td>$group->group_name</th>
                    </tr>
                ";
            }

            $res->setTitle('Группы');
            $res->sendHTML("
                <table class='table table-bordered table-hover caption-top'>
                    <caption class='fw-bold'>Список групп</caption>
                    <thead>
                        <tr>
                            <th scope='col'>Название группы</th>
                        </tr>
                    </thead>
                    <tbody class='font-monospace'>
                        $groupsMarkup
                    </tbody>
            ");
        }
    }

    public static function Group(Request $req, Response $res)
    {
        global $StudentsModel;

        $students = $StudentsModel->find(['group_id' => $req->params['id']]);

        $res->setTitle('Список студентов');

        if ($students) {
            $studentsMarkup = '';

            foreach ($students as $student) {
                $studentsMarkup .= "
                    <li class='list-group-item' onclick=window.location.href='/students/$student->_student_id' style='cursor: pointer;'>$student->first_name $student->second_name</li>
                ";
            }

            $res->sendHTML("
                <div class='card border-warning font-monospace'>
                <div class='card-header text-center'>Список студентов в группе</div>
                <div class='card-body'>
                    <ul class='list-group list-group-flush'>
                        $studentsMarkup
                    </ul>
                </div>
            </div>
            ");
        } else {
            $res->sendHTML("
                <p class='font-monospace'>Студенты не найдены</p>
            ", 404);
        }
    }
}
