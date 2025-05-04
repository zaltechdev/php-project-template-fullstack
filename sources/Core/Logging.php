<?php

namespace App\Core;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Logging{
	
    private function turnOffErrorDisplay(){
        error_reporting(0);
        ini_set("display_errors",0);
    }

    public function __construct(){
        try{			
			$mode = Environment::env("app_mode");
			if($mode === APP_MODE_PROD){
				$this->turnOffErrorDisplay();
			}
			else if($mode === APP_MODE_MAIN){
				$this->turnOffErrorDisplay();
				Routing::unavailable();
			}
		
            $timezone = Environment::env("app_timezone");
            if(!in_array($timezone,timezone_identifiers_list())){
                throw new \Exception("Invalid timezone setting value!");
            }
            date_default_timezone_set($timezone);
        }
        catch(\Exception $error){
            self::record("error",$error,self::class);
            Routing::internalError();
        }
    }

    public static function record(string $level, string | \Throwable $message, string $trace){
        $log_timezone = new \DateTimeZone(DEFAULT_TIMEZONE);
        $log_datetime = new \DateTime("now",$log_timezone);

        $log = new Logger($trace);
        $log->setTimezone($log_timezone);
        $log->pushHandler(new StreamHandler(LOG_DIR . $log_datetime->format("d-m-Y") . ".log"));
        
        $message = is_string($message) ? $message : $message->getMessage();

        if(method_exists(Logger::class, $level)){
            $log->$level($message);
        } else { 
            $log->debug($message);
        }

        $log->close();
        unset($log, $log_timezone, $log_datetime);
    } 
}