<?php

namespace Ez;

use Ez\Request;
use ReflectionMethod;
use Exception;

class Router
{

	private static $request;

	const foot_class = 'Controller';

	private function getDependency($object, $method)
	{
		$reflection = new ReflectionMethod($object, $method);
				
		$parameters = $reflection->getParameters();
		
		$dependencys = [];
		
		foreach ($parameters as $parameter){
			
			if (method_exists($parameter, 'hasType') and $parameter->hasType()){
				
					
				$dependency = '\\' . $parameter->getType()->__toString();

				if (class_exists($dependency)){
					
					array_push($dependencys, new $dependency);
				
				} else {

					die("Objek $dependency tidak ditemukan.");
				}
			} else {

				die("
					Parameter $$parameter->name tidak diperbolehkan.
					Gunakan dependency injection hanya dalam php7."
				);
			}
		}

		return $dependencys;
	}

	private function call($class, $method)
	{
		if (class_exists($class)){
	
			$controller = new $class;

			if(method_exists($controller, $method)){

				
				$arguments = $this->getdependency($controller, $method);
				
				return call_user_func_array([$controller, $method], $arguments);
			}

			throw new Exception(
				"Controller $class tidak memiliki method $method.",
				404
			);
		}

		throw new Exception("Controller $class tidak ditemukan.", 404);
	}

	private function extractUrl($url)
	{

		$namespace = explode('/',  ltrim($url, '/') );
		
		$arr_pisah_method = array_splice($namespace, (count($namespace) - 1));
		$str_ambil_method =
			strtolower(Request::method()).'_'.$arr_pisah_method[0];
		
		if (Request::isAjax()){

			$str_ambil_method =  'ajax_'. $str_ambil_method;
		}
		
		$method = camelCase($str_ambil_method);


		$arr_pisah_class = array_splice($namespace, (count($namespace) - 1));
		
		if (isset($arr_pisah_class[0])){

			$class = studlyCase($arr_pisah_class[0] . self::foot_class);
		
		} else {

			$class = studlyCase($arr_pisah_method[0] . self::foot_class);
		}

		if (empty($namespace)){
			
			$class =  '\\' . $class;

		} else {

			$namespace = array_map(function($val){

				return  studlyCase(ucfirst(strtolower($val)));
				
			}, $namespace);

			$class =  '\\' .  implode('\\' , $namespace) . '\\' . $class;
		}
		
		return compact('class', 'method');
	}

	public function start($default_url)
	{
		
		$url = Request::url();

		if ('/' == $url) $url = $default_url;

		extract( $this->extractUrl($url) );

		$result = $this->call($class, $method);
	
		if (is_array($result)){

			header('content-type:application/json');
			die(json_encode($result));
		}

		return $result;
	}
}