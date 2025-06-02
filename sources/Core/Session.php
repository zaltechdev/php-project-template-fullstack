<?php

namespace App\Core;

class Session{
    
    public function __construct(){
        try{
            $status = session_status();
            if($status === PHP_SESSION_DISABLED){
                throw new \Exception("PHP session currently disabled!");
            }
            
            $driver = new SessionDriver();
            if(!session_set_save_handler($driver,true)){
                throw new \Exception("Failed to set session handler!");
            }
            else if(!session_name(Environment::env("session_cookie_idname"))){
                throw new \Exception("Failed to set session id name!");                
            }
            else if(!session_set_cookie_params([
                "httponly" => true,
                "samesite" => "Strict"
            ])){
                throw new \Exception("Failed to set PHP session cookie params!");
            }
            else if($status === PHP_SESSION_NONE){
                if(!session_start()){
                    throw new \Exception("Failed to start session!");
                }
                if(!session_regenerate_id(true)){
                    throw new \Exception("Failed to regenerate session id!");
                }      
                $gc = $driver->gc();
                if(is_bool($gc) && $gc == false){
                    throw new \Exception("Failed to execute session garbage collection!");
                }
            }
        }
        catch(\Exception $error){
            Logging::record("error",$error,self::class);
            Routing::internalError();
        }
    }
}