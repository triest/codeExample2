<?php
class DB {
    private $pdo;
    public $username=*****;
    public $password=*****;
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

