<?php

namespace App\Core;

class Security{
	
    private static string $input_name;
    private static string $session_name;
	
	public function __construct(){		
        self::$input_name = Environment::env("csrf_inpname");
        self::$session_name = Environment::env("csrf_sessname");
        self::loadCsrf();
	}

	public static function loadCsrf():void{
        if(empty(get_session(self::$session_name))){
            set_session(self::$session_name,bin2hex(random_bytes(16)));
        }
    }

    public static function getCsrf():string{
        return get_session(self::$session_name);
    }

    public static function csrfField():void{
        echo '<input type="hidden" 
            style="opacity:0;visibility:hidden;" 
            name="'.self::$input_name.'" 
            value="'.self::getCsrf().'">';
    }

    public static function validateCsrf():bool{
        $input = post(self::$input_name);
        $session = self::getCsrf();
        $is_valid = !empty($input) && !empty($session) && hash_equals($session,$input);
        unset_session(self::$session_name);
        self::loadCsrf();
        return $is_valid;
    }
}