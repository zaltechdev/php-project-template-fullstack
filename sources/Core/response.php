<?php

function view(string $name, array $data = [], int $code = 200):array{
	return [
		"view" => [
			"data" => $data,
			"name" => $name,
			"code" => $code
		]
	];
}

function redirect(string $path):array{
	return ["redirect" => $path];
}

function json(array $data, int $code = 200){
	return [
		"json" => [
			"message" => $data,
			"code" => $code
		]
	];
}