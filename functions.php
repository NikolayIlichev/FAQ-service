<?php

/**
*    Функция для создания подключения к базе.
**/
function db()
{
    static $db = null;
    include 'config.php';

    if ($db === null) {
        try {
            $db = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8',
                $config['user'],
                $config['pass']
            );
        } catch (PDOException $e) {
            die('Database error: ' . $e->getMessage() . '<br/>');
        }
    }
    return $db;
}

/**
*    Функция для вывода шаблонов с html
**/
function render($template, $data = '', $msg = '')
{
    include 'view/'.$template;
}

/**
*    Функция для записи сообщений в лог
**/
function writeLog($data)
{
    file_put_contents('logs/log.txt', $data, FILE_APPEND);
}
?>
