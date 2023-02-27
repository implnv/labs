<?php
class SheetsController
{
    public static function Sheets(Request $req, Response $res)
    {
        global $DisciplinesModel;

        $res->setTitle('Ведомость');
        $res->sendHTML("
            <p class='font-monospace'>Ведомость</p>
        ");
    }
}
