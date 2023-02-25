<?php
class GroupsController
{
    public static function Groups(Request $req, Response $res)
    {
        global $ExampleModel;

        $res->setTitle('Группы');
        $res->sendHTML("
            <p class='font-monospace'>Группы</p>
        ");
    }
}
