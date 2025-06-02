<?php

namespace App\Core;

class Database{

    public static function query(string $statement, array $params = []){
        $hostname = Environment::env("database_hostname");
        $driver = Environment::env("database_driver_prefix");
        $username = Environment::env("database_username");
        $password = Environment::env("database_password");
        $dbname = Environment::env("database_dbname");

        try{
            $dsn = "$driver:host=$hostname;dbname=$dbname";
            $pdo = new \PDO($dsn,$username,$password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
            $query = $pdo->prepare($statement);
            $query->execute($params);
            return $query;
        }
        catch(\PDOException $error){
            Logging::record("error",$error,self::class);
            return false;
        }
    }
}