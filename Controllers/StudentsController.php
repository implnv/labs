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
                <div class='modal fade' id='addStudentModal' aria-hidden='true' aria-labelledby='addStudentModalLabel' tabindex='-1'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='addStudentModalLabel'>Добавление студента</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <input type='text' class='form-control mb-1' placeholder='Имя студента' aria-label='Имя студента'>
                                <input type='text' class='form-control mb-1' placeholder='Фамилия студента' aria-label='Фамилия студента'>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата рождения</span>
                                    <input class='form-control' type='date' placeholder='dasda'>
                                </div>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата поступления</span>
                                    <input class='form-control' type='date' placeholder='dasda'>
                                </div>
                                <select class='form-select'>
                                    <option selected disabled>Группа</option>
                                    <option value='1'>One</option>
                                </select>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-outline-dark' onclick='addStudent()'>Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='d-flex flex-row-reverse'>
                    <div class='btn-group' role='group' aria-label='Basic example'>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' href='#addStudentModal' role='button'>Добавить</button>
                        <button type='button' class='btn btn-danger' onclick='removeStudent()'>Удалить</button>
                        <button type='button' class='btn btn-warning' onclick='editStudent()'>Редактировать</button>
                    </div>
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
                    <script>
                        let xhr = new XMLHttpRequest();

                        const request = (method = 'GET', path, jsonData) => {
                            if (!path) {
                                return
                            }
                            xhr.open(method, path)
                            if (method === 'POST') {
                                xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8')
                                xhr.send(jsonData)
                            }
                            else {
                                xhr.send()
                            }
                        }

                        const addStudent = () => {
                            request('POST', '/students/add', JSON.stringify({
                                first_name: 'Вася',
                                second_name: 'Петров',
                                birth_date: '2020-01-01',
                                receipt_date: '2018-01-01',
                                group_id: '2'
                            }))
                        }

                        const removeStudent = () => {
                            request('DELETE', '/students/remove', JSON.stringify({
                                student_id: 0
                            }))
                        }

                        const editStudent = () => {
                            request('PATCH', '/students/edit', JSON.stringify({
                                first_name: 'Вася',
                                second_name: 'Петров',
                                birth_date: '2020-01-01',
                                receipt_date: '2018-01-01',
                                group_id: '1'
                            }))
                        }
                    </script>
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

    public static function StudentAdd(Request $req, Response $res)
    {
        global $StudentsModel;
        print_r($req->body);
        // $StudentsModel->create([
        //     "first_name"    => $req->body["first_name"],
        //     "second_name"   => $req->body["second_name"],
        //     "birth_date"    => $req->body["birth_date"],
        //     "receipt_date"  => $req->body["receipt_date"],
        //     "group_id"      => $req->body["group_id"]
        // ]);
    }

    public static function StudentRemove(Request $req, Response $res)
    {
        
    }

    public static function StudentEdit(Request $req, Response $res)
    {
        
    }
}
