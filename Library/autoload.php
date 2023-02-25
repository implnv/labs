<?php
spl_autoload_register(function ($class) {
    $fileEngine = 'Library/' . $class . '/' . $class . '.php';
    $fileModel  = 'Models/' . $class . '.php';
    $fileController = 'Controllers/' . $class . '.php';

    if (file_exists($fileEngine)) {
        require_once($fileEngine);
    }

    if (file_exists($fileModel)) {
        require_once($fileModel);
    }

    if (file_exists($fileController)) {
        require_once($fileController);
    }
});
