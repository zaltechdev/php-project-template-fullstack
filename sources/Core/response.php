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