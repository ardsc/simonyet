<?php

namespace Ez\Driver;

use Ez\Contracts\Database;

class Postgre implements Database
{
	public function connect($db_host, $db_name, $db_user, $db_pass)
	{
        return pg_connect(
        	"host=$db_host
        	port=5432
        	dbname=$db_name
        	user=$db_user
        	password=$db_pass"
        );
	}

	public function close($db_handler)
	{
		return pg_close($db_handler);
	}

	public function query($db_handler, $query)
	{
		return pg_query($db_handler, $query);
	}

	public function fetch($result, $type = false)
	{
		if($type == 'object')
			return pg_fetch_object($result);
		else
			return pg_fetch_assoc($result);
	}

	public function free($result)
	{
		return pg_free_result($result);
	}

	public function escape($db_handler, $string)
	{

		return pg_escape_string($db_handler, $string);
	}

}