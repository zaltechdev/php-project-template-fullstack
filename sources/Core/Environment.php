<?php

namespace App\Core;

use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\ValidationException;

class Environment{

	private function catchEnvError(string $message){
		Logging::record("error",$message,self::class);
		Routing::internalError();
	}

	public function __construct(){
		try{
			$env_file = ROOT_DIR . ".env";
			if(!file_exists($env_file)){
				throw new InvalidPathException("Env file does not exist, invalid path, or missing!");
			}
			
			$dotenv = \Dotenv\Dotenv::createImmutable(ROOT_DIR);
			$dotenv->safeLoad();
		}
		catch(InvalidFileException $error){
			$this->catchEnvError($error);
		}
		catch(InvalidPathException $error){
			$this->catchEnvError($error);
		}
		catch(InvalidEncodingException $error){
			$this->catchEnvError($error);
		}
		catch(ValidationException $error){
			$this->catchEnvError($error);
		}
	}

	public static function env(string $key){
		return $_ENV[$key] ?? "";
	}
}

