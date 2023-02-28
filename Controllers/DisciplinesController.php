<?php
class DisciplinesController
{
    public static function Disciplines(Request $req, Response $res)
    {
        global $DisciplinesModel;

        $disciplines = $DisciplinesModel->find([]);

        if ($disciplines) {
            $disciplinesMarkup = '';

            foreach ($disciplines as $discipline) {
                $disciplinesMarkup .= "
                    <tr id='$discipline->_discipline_id'>
                        <td>$discipline->discipline_name</th>
                    </tr>
                ";
            }

            $res->setTitle('Студенты');
            $res->sendHTML("
                <table class='table table-bordered table-hover caption-top'>
                    <caption class='fw-bold'>Список дисциплин</caption>
                    <thead>
                        <tr>
                            <th scope='col'>Название дисциплины</th>
                        </tr>
                    </thead>
                    <tbody class='font-monospace'>
                        $disciplinesMarkup
                    </tbody>
            ");
        } else {
            $res->sendHTML("
                <p class='font-monospace'>Дисциплины не найдены</p>
            ", 404);
        }
    }
}
