<?php

if (!defined('DB_HOST')) {

    define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
    define('VIEW_PATH', BASE_PATH . 'App' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR);

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_PORT', '3306');
    define('DB_DB', 'ar-desenvolvimento');
}
