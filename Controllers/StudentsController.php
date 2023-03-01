<?php
class StudentsController
{
    public static function Students(Request $req, Response $res)
    {
        global $StudentsModel;
        global $GroupsModel;

        $students = $StudentsModel->select()->leftJoin('groups', ['group_id' => 'group_id'])->eq()->requestAll();
        $groups   = $GroupsModel->find([]);

        if ($students) {
            $studentsMarkup = '';
            $groupsMarkup   = '';

            foreach ($students as $student) {
                $studentsMarkup .= "
                    <tr id='$student->_student_id' onclick=window.location.href='students/$student->_student_id'>
                        <td>$student->_student_id</th>
                        <td>$student->first_name</th>
                        <td>$student->second_name</td>
                        <td>$student->birth_date</td>
                        <td>$student->receipt_date</td>
                        <td>$student->group_name</td>
                    </tr>
                ";
            }

            foreach ($groups as $group) {
                $groupsMarkup .= "<option value='$group->_group_id'>$group->group_name</option>";
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
                                <input type='text' id='firstName' class='form-control mb-1' placeholder='Имя студента' aria-label='Имя студента'>
                                <input type='text' id='secondName' class='form-control mb-1' placeholder='Фамилия студента' aria-label='Фамилия студента'>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата рождения</span>
                                    <input id='brithDate' class='form-control' type='date'>
                                </div>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата поступления</span>
                                    <input id='receiptDate' class='form-control' type='date' placeholder='dasda'>
                                </div>
                                <select id='group' class='form-select'>
                                    <option selected disabled>Группа</option>
                                    $groupsMarkup
                                </select>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-outline-dark' onclick='addStudent()'>Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='removeStudentModal' aria-hidden='true' aria-labelledby='removeStudentModalLabel' tabindex='-1'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='removeStudentModalLabel'>Удаление студента</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <input type='text' id='studentId' class='form-control mb-1' placeholder='Id студента' aria-label='Id студента'>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-outline-dark' onclick='removeStudent()'>Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='editStudentModal' aria-hidden='true' aria-labelledby='editStudentModalLabel' tabindex='-1'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='editStudentModalLabel'>Редактирование студента</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <input type='text' id='studentIdEdit' class='form-control mb-1' placeholder='Id студента' aria-label='Id студента'>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-outline-dark' data-bs-target='#editStudentModal2' data-bs-toggle='modal'>Далее</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='editStudentModal2' aria-hidden='true' aria-labelledby='editStudentModalLabel2' tabindex='-1'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='editStudentModalLabel2'>Редактирование студента</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <input type='text' id='firstNameEdit' class='form-control mb-1' placeholder='Имя студента' aria-label='Имя студента'>
                                <input type='text' id='secondNameEdit' class='form-control mb-1' placeholder='Фамилия студента' aria-label='Фамилия студента'>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата рождения</span>
                                    <input id='brithDateEdit' class='form-control' type='date'>
                                </div>
                                <div class='input-group input-group-sm mb-1'>
                                    <span class='input-group-text'>Дата поступления</span>
                                    <input id='receiptDateEdit' class='form-control' type='date' placeholder='dasda'>
                                </div>
                                <select id='groupEdit' class='form-select'>
                                    <option selected disabled>Группа</option>
                                    $groupsMarkup
                                </select>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-outline-dark' onclick='editStudent()'>Сохранить изменения</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='d-flex flex-row-reverse'>
                    <div class='btn-group' role='group' aria-label='Basic example'>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' href='#addStudentModal' role='button' accesskey='z'>Добавить</button>
                        <button type='button' class='btn btn-danger' data-bs-toggle='modal' href='#removeStudentModal' role='button' accesskey='x'>Удалить</button>
                        <button type='button' class='btn btn-warning' data-bs-toggle='modal' href='#editStudentModal' accesskey='c'>Редактировать</button>
                    </div>
                </div>
                <table class='table table-bordered table-hover caption-top'>
                    <caption class='fw-bold'>Список студентов</caption>
                    <thead>
                        <tr>
                            <th scope='col'>#</th>
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
                        const request = (method, path, jsonData) => {
                            if (!path || !method) {
                                return
                            }

                            let xhr = new XMLHttpRequest()
                            xhr.open(method, path)

                            if (method === 'POST' || method === 'PATCH') {
                                xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8')
                                xhr.send(jsonData)
                            }
                            else {
                                xhr.send()
                            }
                        }

                        const addStudent = () => {
                            request('POST', '/students/add', JSON.stringify({
                                first_name: firstName.value,
                                second_name: secondName.value,
                                birth_date: brithDate.value,
                                receipt_date: receiptDate.value,
                                group_id: group.value
                            }))
                        }

                        const removeStudent = () => {
                            const path = '/students/' + studentId.value + '/remove'
                            request('DELETE', path)
                        }

                        const editStudent = () => {
                            const path = '/students/' + studentIdEdit.value + '/edit'
                            request('PATCH', path, JSON.stringify({
                                first_name: firstNameEdit.value,
                                second_name: secondNameEdit.value,
                                birth_date: brithDateEdit.value,
                                receipt_date: receiptDateEdit.value,
                                group_id: groupEdit.value
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

        $StudentsModel->create([
            "first_name"    => $req->body["first_name"],
            "second_name"   => $req->body["second_name"],
            "birth_date"    => $req->body["birth_date"],
            "receipt_date"  => $req->body["receipt_date"],
            "group_id"      => $req->body["group_id"]
        ]);
    }

    public static function StudentRemove(Request $req, Response $res)
    {
        global $StudentsModel;

        $StudentsModel->deleteOne(['student_id' => $req->params['id']]);
    }

    public static function StudentEdit(Request $req, Response $res)
    {
        global $StudentsModel;

        $StudentsModel->updateOne([
            'first_name'    => $req->body['first_name'],
            'second_name'   => $req->body['second_name'],
            'birth_date'    => $req->body['birth_date'],
            'receipt_date'  => $req->body['receipt_date'],
            'group_id'      => $req->body['group_id']
        ], [
            'student_id' => $req->params['id']
        ]);
    }
}
