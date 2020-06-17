<?php

namespace Ez;

use Ez\View;

class ErrorHandler
{

	private static $debug = false;
	
	public static function debug()
	{

		static::$debug = true;
	}

	public static function display($type, $message, $file, $line)
	{

		ob_clean();


		$render = [
			'type' => $type,
			'message' => 'Mohon maaf, sepertinya sedang terjadi kesalahan',
			'sub_message' => 'Mohon tunggu beberapa saat lagi,
				sementara kami sedang memperbaikinya, terimakasih.'
		];

		if (404 == $type){

			$render['sub_message'] = 'Halaman yang Anda cari tidak ditemukan.';
		}
		

		if (static::$debug === true){
			
			$render = [
				'type' => $type,
				'message' => $message,
				'sub_message' => $file . ' on line ' . $line
			];	
		}

		$render['layout'] = false;
		
		
		View::render('Ez.View.error', $render);

		tulisLog(
			clientIp() . " | $type | $message | $file | $line", 'error.log'
		);

		exit;
	}

	public static function register()
	{
		
		set_exception_handler(function($exc){

			self::display(
				$exc->getCode(),
				$exc->getMessage(),
				$exc->getFile(),
				$exc->getLine()
			);
		});

		set_error_handler(function($type, $message, $file, $line){

			self::display($type, $message, $file, $line);
		});

		register_shutdown_function(function(){
			
			if($error = error_get_last()){

				extract($error);

				self::display($type, $message, $file, $line);
			}
		});
	}
}