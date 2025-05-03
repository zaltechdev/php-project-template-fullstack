<?php

namespace MyFinance\Core;

class Session{
	
	public function __construct(){
		try{
			$session_status = session_status();
			if($session_status == PHP_SESSION_DISABLED){
				throw new \Exception("PHP session is disabled!");
			}
            if(!session_save_path(SESSION_DIR)){
                throw new \Exception("Failed to set session save path!");
            }
			if(!session_name(Environment::env("session_cookie_idname"))){
				throw new \Exception("PHP session name failed to set!");
			}
			if($session_status == PHP_SESSION_NONE){
				if(!session_start()){
					throw new \Exception("Failed to start PHP session!");
				}
				if(!session_regenerate_id(true)){
					throw new \Exception("Failed to set session regeneration!");
				}
			}
		}
		catch(\Exception $error){
			Logging::record("error",$error,self::class);
			Routing::internalError();
		}
	}
}