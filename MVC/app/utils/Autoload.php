<?php

class Autoload
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class): void
    {
        $paths = [
            __DIR__ . '/../entities/' . $class . '.php',
            __DIR__ . '/../controllers/' . $class . '.php',
            __DIR__ . '/../models/' . $class . '.php',
            __DIR__ . '/../utils/' . $class . '.php'
        ];

        foreach ($paths as $file) {
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }

        die('<p>Fichier introuvable pour la classe : ' . $class . '</p>');
    }
}
?>