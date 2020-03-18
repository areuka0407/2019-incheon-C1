<?php
namespace App;

class DB {
    static $conn = null;
    static function getConnection(){
        $options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
        if(self::$conn === null){
            self::$conn = new \PDO("mysql:host=localhost;dbname=2019_incheon_c1;charset=utf8mb4", "root", "", $options);
        }
        return self::$conn;
    }

    static function execute($sql, $data = []){
        $q = self::getConnection()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    static function fetch($sql, $data = []){
        return self::execute($sql, $data)->fetch();
    }

    static function fetchAll($sql, $data = []){
        return self::execute($sql, $data)->fetchAll();
    }

    static function find($table, $id){
        return self::fetch("SELECT * FROM `${table}` WHERE id = ?", [$id]);
    }
}