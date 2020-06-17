<?php

namespace Ez;

class Loader
{

    protected $prefixes = [];

    public function __construct()
    {

        spl_autoload_register([$this, 'loadClass']);
    }

    public function addNamespace($prefix, $base_dir)
    {

        $prefix = trim($prefix, '\\') . '\\';

        $base_dir = rtrim($base_dir, '/').'/';

        if (isset($this->prefixes[$prefix]) === false){
        	
            $this->prefixes[$prefix] = [];
        }

        array_push($this->prefixes[$prefix], $base_dir);
    }

    public function loadClass($class)
    {

        $prefix = $class;

        while (false !== $pos = strrpos($prefix, '\\')){

            $prefix = substr($class, 0, $pos + 1);

            $relative_class = substr($class, $pos + 1);

            $mapped_file = $this->loadMappedFile($prefix, $relative_class);
            
            if ($mapped_file) return $mapped_file;

            $prefix = rtrim($prefix, '\\');   
        }

        return false;
    }

    protected function loadMappedFile($prefix, $relative_class)
    {

        if (isset($this->prefixes[$prefix]) === false) return false;
        foreach ($this->prefixes[$prefix] as $base_dir){

            $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';

            if ($this->requireFile($file)) /*yes, we're done*/ return $file;
        }

        return false;
    }

    public function requireFile($file)
    {

        if (file_exists($file)){
            
            require $file;
            return true;
        }

        return false;
    }
}