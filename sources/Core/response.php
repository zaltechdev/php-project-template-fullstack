<?php

function view(string $name, array $data = [], int $code = 200){
	return [
		"view" => [
			"data" => $data,
			"name" => $name,
			"code" => $code
		]
	];
}

function redirect(string $path){
	return ["redirect" => $path];
}

function showFile(string $file_name){
	return ["file" => $file_name];
}