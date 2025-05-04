<?php

function css(string $css_name){
	return "/assets/css/$css_name.css";
}

function js(string $js_name){
	return "/assets/js/$js_name.js";
}

function csrf_field(){
	App\Core\Security::csrfField();
}

function generate_6digit_token(){
	$pool = "1234567890";
	$token = "";
	for($i = 0; $i < 6; $i++){
		$token .= $pool[rand(0,strlen($pool) - 1)];
	}
	return $token;
}

function generate_uuid4() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function validate_submit_button(string $button_name, string $button_value){
    return hash_equals($button_value,post($button_name));
}

function view_template(string $template_name, array $data = []){
	$template = VIEW_TEMPLATES_PATH . "$template_name.php";
	if(file_exists($template)){
		extract($data);
		require_once $template;
	}
	else {
		App\Core\Logging::record("error","View template file $template_name does not exist or invalid name!", "view_template()");
	}
	return;
}

function global_assets(array $css, array $js){
	if(!empty($css)){
		foreach($css as $style){
			echo '<link rel="stylesheet" href="'.css($style).'"></a>';
		}		
	}
	
	if(!empty($js)){
		foreach($js as $script){
			echo '<script src="'.js($script).'"></script>';
		}		
	}
}

function get_app_name(){
	return App\Core\Environment::env("app_name");
}