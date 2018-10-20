<?php
class DB {
    private $pdo;
    public $username=a0188141_task;
    public $password=a0188141;
    public function __construct($host, $dbname, $username, $password) {
        $pdo = new PDO('mysql:host='.localhost.';dbname='.a0188141_task.';charset=utf8', $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }
    public function query($query, $params = array()) {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
    }
}

//база и проль и пользователь//a0188141_task
/*
Имя базы данных:  	a0188141_task
Адрес хоста:  	localhost
Пользователь:  	a0188141_task
Пароль:  	a0188141
 * */