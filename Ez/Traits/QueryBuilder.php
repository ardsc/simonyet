<?php

namespace Ez\Traits;

trait QueryBuilder {

    private
        $coloum = [],
        $wcoloum = [],
        $sql = false,
        $wsql = false,
        $obsql = false,
        $table = false;

    public function __set($coloum, $value)
    {

    	$this->coloum[$coloum] = $value;
    }

    private function tableName()
    {

        return $this->table != false ? $this->table : get_called_class();
    }

    public function table($name)
    {

        $this->table = $name;
        return $this;
    }

    public function arg(array $args = [])
    {
        $args = implode("', '", self::escape($args));

        $this->table .= "('{$args}')";

        return $this;
    }

    public function select()
    {
        $coloum = func_get_args();
        $coloum = empty($coloum) ? '*' : implode(', ', $coloum);

        $table = $this->tableName();

        $this->sql = "select {$coloum} from {$table}";

        return $this;
    }


    public function count()
    {
        $coloum = func_get_args();
        $coloum = empty($coloum) ? '*' : implode(', ', $coloum);

        $table = $this->tableName();

        $this->sql = "select count({$coloum}) from {$table}";

        return $this;
    }

    public function orderBy()
    {
        $coloum = func_get_args();

        $this->obsql = ' order by ' . implode(', ', $coloum);

        return $this;
    }

    public function asc()
    {

        $this->obsql .= ' asc';
        return $this;
        
    }

    public function desc()
    {

        $this->obsql .= ' desc';
        return $this;
    }

    public function insert(array $data = [])
    {

    	$data = empty($data) ? $this->coloum : $data;

    	$coloum = implode(',', $this->escape(array_keys($data)));

		$value = array_map(function($value){

            $value = $this->escape($value);
			return "'{$value}'";

		}, array_values($data));

		$value = implode(',', $value);

        $table = $this->tableName();

		$this->sql = "insert into {$table}({$coloum}) values({$value})";

		return $this;
    }

    public function update(array $data = [])
    {
        $data = empty($data) ? $this->coloum : $data;

        $arr_data = [];
        foreach ($data as $coloum => $value) {
            
            $coloum = $this->escape($coloum);
            $value = $this->escape($value);

            $arr_data[] = "{$coloum} = '$value'";
        }

        $data = implode(', ', $arr_data);
        

        $table = $this->tableName();

        $this->sql = "update {$table} set {$data}";

        return $this;
    }

    public function where($coloums, $kondisi = false, $value = false)
    {

        if (is_array($coloums)) {

            foreach ($coloums as $coloum => $value) {
                    
                $value = $this->escape($value);

                if (is_array($value)) {

                    $this->wcoloum[] = "{$value[0]} {$value[1]} '{$value[2]}'";
                
                } else {
                    
                    $coloum = $this->escape($coloum);

                    $this->wcoloum[] = "{$coloum} = '{$value}'";

                }

            }

        } else if ($kondisi !== false and $value === false) {
            
            $coloums = $this->escape($coloums);
            $kondisi = $this->escape($kondisi);

            $this->wcoloum[] = "{$coloums} = '{$kondisi}'";

        } else if ($kondisi !== false and $value !== false) {
            
            
            $coloums = $this->escape($coloums);
            $kondisi = $this->escape($kondisi);
            $value = $this->escape($value);

            $this->wcoloum[] = "{$coloums} {$kondisi} '{$value}'";
        }

        $this->wsql = ' where ' . implode(' and ', $this->wcoloum);

        return $this;
    }

    public function delete()
    {
        
        $table = $this->tableName();

        $this->sql = "delete from {$table}";

        return $this;
    }

    public function getSql()
    {
    	return $this->sql . $this->wsql . $this->obsql;
    }

    public function run($sql = false)
    {

        if (false == $sql) {

            return $this->query($this->getSql());
        }

    	return $this->query($sql);
    }

    public function raw($sql, $prepare_var = false, $callback = false)
    {

        if (is_array($prepare_var)) {

            foreach ($prepare_var as $key => $val) {

                $key = $this->escape($key);
                $val = $this->escape($val);

                $sql = str_replace(":{$key}", "'{$val}'", $sql);
            }
        }   

        $query = $this->query($sql);

        if (is_callable($prepare_var)) {

            $callback = $prepare_var;

        } else if(false == $callback) {

            $callback = function($item) {

                return $item;
            };
        }
        
        $data = [];
        while ($item = $this->assoc($query)){

               
            $data[] = $callback($item);
        }

        return $data;
    }

    public function lastInsertId(){

        $this->run();
        $query = $this->query('select last_insert_id() as id');
        $result = $this->assoc($query);
        

        if ($result) {

            return $result['id'];
        }
        
        return false;
    }

    public function returning($coloum)
    {

        $this->sql .= ' returning ' . $this->escape($coloum);

        $result = $this->assoc($this->run());

        if ($result) {

            return $result[$coloum];
        }
        
        return false;
    }

    public function get($callback = false)
    {
    	$query = $this->run();


        $data = [];

        if ($callback == false) {

            $callback = function($item) {

                return $item;
            };
        }

    	
    	while ($item = $this->assoc($query)){

               
            $data[] = $callback($item);
        }

    	return $data;
    }

    public function one()
    {

        return $this->assoc($this->run());
    }

    public function all($callback = false)
    {

    	return $this->select()->get($callback);
    }
}
