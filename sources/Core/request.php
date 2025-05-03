<?php

function post(string $key){
	return htmlspecialchars($_POST[$key] ?? "");
}

function get(string $key){
	return htmlspecialchars($_GET[$key] ?? "");
}

function posts(array $keys){
	$data = [];
	foreach($keys as $key){
		$data[$key] = post($key);
	}
	
	return $data;
}

function gets(array $keys){
	$data = [];
	foreach($keys as $key){
		$data[$key] = get($key);
	}
	
	return $data;
}

function set_session(string $key, mixed $value){
	$_SESSION[$key] = $value;
}

function unset_session(string $key){
	unset($_SESSION[$key]);
}

function get_session(string $key){
	return $_SESSION[$key] ?? "";
}

