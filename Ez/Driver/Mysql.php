<?php

namespace Ez\Driver;

use Ez\Contracts\Database;

class Mysql implements Database
{
	public function connect($db_host, $db_name, $db_user, $db_pass)
	{

        return mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	}

	public function close($db_handler)
	{
		return mysqli_close($db_handler);
	}

	public function query($db_handler, $query)
	{
		return mysqli_query($db_handler, $query);
	}

	public function fetch($result, $type = false)
	{
		if($type == 'object')
			return mysqli_fetch_object($result);
		else
			return mysqli_fetch_assoc($result);
	}

	public function free($result)
	{
		return mysqli_free_result($result);
	}

	public function escape($db_handler, $string)
	{

		return mysqli_real_escape_string($db_handler, $string);
	}
}