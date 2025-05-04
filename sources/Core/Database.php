<?php

namespace App\Core;

class Database{

    private static \PDO | null $db = null;
    private static \PDOStatement | null $stmt = null;
    private static array $result = [];

    private static function catchDatabaseError($message){
        Logging::record("error",$message,self::class);
        self::$result['status'] = false;
    }
    
    public function __construct(){
        if(self::$db == null){
            try{
                $database_dsn = DATABASE_DIR . (Environment::env("database_filename") ?? "database.sqlite");
                if(!file_exists($database_dsn)){
                    throw new \Exception("Invalid database DSN. Database is missing, not found, or incorrect path!");
                }

                $pdo = new \PDO(DATABASE_DRIVER_PREFIX . $database_dsn);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
                self::$db = $pdo;
                self::$result['status'] = true;
            }
            catch(\PDOException $error){
                Logging::record("error",$error,self::class);
                self::$db = null;
                self::$result['status'] = false;
            }
            catch(\Exception $error){
                self::$db = null;
                self::catchDatabaseError($error);
            }
        }
    }

    public static function query(string $query, array $params = []){
        if(self::$db){
            try{
                $stmt = self::$db->prepare($query);
                $stmt->execute($params);
                self::$stmt = $stmt;
            }   
            catch(\PDOException $error){
                self::catchDatabaseError($error);
            }
        }
        return new static;
    }

    public function fetchAll(){
        if(self::$result['status']){
            self::$result['fetchAll'] = self::$stmt->fetchAll();
        }
        return new static;
    }

    public function fetchColumn(){
        if(self::$result['status']){
            self::$result['fetchColumn'] = self::$stmt->fetchColumn();
        }
        return new static;
    }
    
    public function rowCount(){
        if(self::$result['status']){
            self::$result['rows'] = self::$stmt->rowCount();
        }
        return new static;
    }

    public function result(){
        self::$stmt = null;
        return self::$result;
    }

}