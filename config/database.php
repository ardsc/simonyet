<?php

return [

	'default' => env('default_db', 'local_db'),

	'connections' => [

		'local_db' => [
			'driver' => env('db_driver', 'mysql'),
			'host' => env('db_host', 'localhost'),
			'name' => env('db_name', 'ardsc'),
			'user' => env('db_user', 'root'),
			'pass' => env('db_pass', '')
		]
	]
];