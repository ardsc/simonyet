<?php

function dump($foo, $vd = false)
{

	echo '<pre>';

	if ($vd){

		var_dump($foo);

	} else  print_r($foo);

	echo '</pre>';
}

function dd($foo, $vd = false)
{
	dump($foo, $vd);
	exit;
}

function rdot($str)
{

	return str_replace('.', '/', $str);
}

function env($key, $default = null)
{

	return Ez\Env::get($key, $default);
}

function config($config_name = null)
{

	return Ez\Config::get($config_name);
}


function session($session_name = false, $val = false)
{

	if (false == $session_name){


		return Ez\Session::get();

	} else if (false == $val){

		return Ez\Session::get($session_name);

	} else {

		Ez\Session::set($session_name, $val);
	}
}

function sessionDestroy()
{

	Ez\Session::destroy();
}

function url($append = false)
{

	return (new Ez\Request)->base() . '/' . $append;
}

function redirect($append = false)
{
	$url = url($append);

	header('location:' . $url);
}

function camelCase($str, array $noStrip = [])
{
        // non-alpha and non-numeric characters become spaces
        $str =
        	preg_replace('/[^a-z0-9'.implode("", $noStrip).']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
}

function studlyCase($str, array $noStrip = [])
{

	return ucfirst(camelCase($str, $noStrip));
}

function generateToken()
{
	$str = str_shuffle('
		1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM
	');

	return substr($str, rand(1, 58), 5);
}

function arrayExcept($key_except, array $array)
{
	$key_excepts = (array) $key_except;

	foreach ($key_excepts as $val){

		if (isset($array[$val])){

			unset($array[$val]);
		}
	}

	return $array;
}

function strLimit($str, $limit = 150)
{
	if (strlen($str) > $limit){
		$str = substr($str, 0, $limit) . '...';
	}
	return $str;
}


function tulisLog($msg, $filename)
{
	$log_file = __DIR__ . '/../' . $filename;

	$log = fopen($log_file, 'a+');
	fwrite($log, date('Y/m/d H:i:s').' | '.
		trim(preg_replace('/\s\s+/', ' ',  $msg))."\n");
	
	fclose($log);
	// chmod($log_file, 0777);
}

function clientIp(){

	//Just get the headers if we can or else use the SERVER global
	if ( function_exists( 'apache_request_headers' ) ){

		$headers = apache_request_headers();

	} else {

		$headers = $_SERVER;

	}

	//Get the forwarded IP if it exists
	if (array_key_exists('X-Forwarded-For', $headers ) and
		filter_var($headers['X-Forwarded-For'],
			FILTER_VALIDATE_IP,
			FILTER_FLAG_IPV4)){

		$the_ip = $headers['X-Forwarded-For'];

	} elseif(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) and
		filter_var($headers['HTTP_X_FORWARDED_FOR'],
			FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )){

		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

	} else {
		
		$the_ip = filter_var($_SERVER['REMOTE_ADDR'],
			FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

	}

	return $the_ip;
}


function baseDir($foo = false)
{
	return realpath(__DIR__.'/../').'/'.$foo;
}


function postRules($rules)
{

	$data = Ez\Request::data()->toArray();
	return (new Ez\Validation)->rules($rules)->data($data)->validate();
}