<?php

namespace MyFinance\Core;

class Routing {
	
	private string $uri;
	private string $http_method;
	private string $base_url;
	private array $routes = [];

	private static function catchRouterError(string $message){
		Logging::record("error",$message,self::class);
	}
	
	public function __construct(){
		$this->uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ?? "/";
		$this->http_method = $_SERVER['REQUEST_METHOD'];
		$this->base_url = Environment::env("base_url");
	}
	
	public static function notFound(){
		http_response_code(404);
		$notfound = VIEW_ERRORS_PATH . "404.php";
		if(file_exists($notfound)){
			require_once $notfound;
			die();
		} 
		die("<center><h2>404 Not Found</h2></center>");
		
	}
	
	public static function methodNotAllowed(){
		http_response_code(405);
		$method_error = VIEW_ERRORS_PATH . "405.php";
		if(file_exists($method_error)){
			require_once $method_error;
			die();
		} 
		die("<center><h2>405 Method Not Allowed</h2></center>");
		
	}
	
	public static function internalError(){
		http_response_code(500);
		$internal_error = VIEW_ERRORS_PATH . "500.php";
		if(file_exists($internal_error)){
			require_once $internal_error;
			die();
		} 
		die("<center><h2>500 Internal Server Error</h2></center>");
		
	}
	
	public static function unavailable(){
		http_response_code(503);
		$unavailable = VIEW_ERRORS_PATH . "503.php";
		if(file_exists(filename: $unavailable)){
			require_once $unavailable;
			die();
		} 
		die("<center><h2>503 Service Unavailable</h2></center>");
		
	}

	private function buildRoute(string $http_method, string $path, array $controller){
		if(hash_equals($http_method,$this->http_method)){
			$this->routes[] = [
				"path" => $path,
				"controller" => $controller
			];
		}
	}

	public function get(string $path, array $controller){
		$this->buildRoute("GET",$path,$controller);
	}
	
	public function post(string $path, array $controller){
		$this->buildRoute("POST",$path,$controller);
	}
	
	public function run(){
		
		foreach($this->routes as $route){
			if(hash_equals($route['path'],$this->uri)){

				$controller_class = $route['controller'][0] ?? "";
				$controller_method = $route['controller'][1] ?? "";
				
				if(!class_exists($controller_class) || !method_exists($controller_class,$controller_method)){
					self::catchRouterError("Class controller or method controller does not exist!");
					self::internalError();
				}
				
				$controller = new $controller_class();
				$return = $controller->$controller_method();
				
				if(isset($return['view'])){
					header("Content-Type:text/html");
					http_response_code($return['view']['code']);
					
					$view = VIEW_MAIN_PATH . $return['view']['name'] . ".php";
					if(!file_exists($view)){
						self::catchRouterError("View $view does not exist!");
						self::internalError();
					}
					
					extract($return['view']['data']);
					require_once $view; 
				}
				else if(isset($return['redirect'])){
					$trimmed_redirect_path = rtrim($this->base_url,"/") . "/" . ltrim($return['redirect'],"/");
					header("location:" . $trimmed_redirect_path);
				}
				else if(isset($return['file'])){
					$uploaded_file = UPLOAD_DIR . $return['file'];
					if(file_exists($uploaded_file)){
						$mime_type = mime_content_type($uploaded_file);
						if($mime_type){
							self::catchRouterError("Failed to get file mime type!");
							self::internalError();
						}
						header("Content-Type:$mime_type");
						if(!readfile($uploaded_file)){
							header("Content-Type:text/html");
							self::catchRouterError("Failed to read file!");
							self::internalError();
						}
					}
				}
				exit;
			}
		}
		
		self::notFound();
	}
}