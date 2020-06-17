<?php

namespace Ez;

use Exception;
use Ez\Traits\QueryBuilder;

class Database
{

    use QueryBuilder;

    private static $driver = null, $dbh = null;

    public static function connect($db_connect = false)
    {

        if (false == $db_connect){

            $db_connect = config('database.default');
        }
        
        $db = config('database.connections.' . $db_connect);
        

        if (is_null($db)){

            throw new Exception(
                "Config database $db_connect tidak ditemukan.",
                E_USER_ERROR
            );
        }

        $driver = '\\Ez\\Driver\\' . ucfirst(strtolower($db['driver']));
        
        static::$driver = new $driver;

        static::$dbh = static::$driver->connect(
            $db['host'],
            $db['name'],
            $db['user'],
            $db['pass']
        );
    }

    private static function driver()
    {

        if (is_null(static::$driver)){

            self::connect();
        }

        return static::$driver;
    }

    public static function query($query)
    {
        return self::driver()->query(static::$dbh, $query);
    }

    public static function object($result)
    {
        
        return self::driver()->fetch($result, 'object');
    }

    public static function assoc($result)
    {
        return self::driver()->fetch($result);
    }

    public static function free($result)
    {

        return self::driver()->free($result);
    }

    public static function escape($string)
    {

        if (is_array($string)) {

            return array_map(function($val){
                
                return self::driver()->escape(static::$dbh, $val);

            }, $string);
        }

        return self::driver()->escape(static::$dbh, $string);
    }

    public static function close()
    {

        if (!is_null(static::$dbh)){
            
            self::driver()->close(static::$dbh);
        }
    }
}