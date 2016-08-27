<?php

/**
 *
 */
class SORM extends Service
{
    public $table;
    public $columns     = [];
    public $primary_key = '';
    public $className   = null;

    public function __construct()
    {
        parent::__construct();

        $this->className = get_class($this);

        if (!isset($this->table)) {
            $this->table = strtolower(get_class($this));
        }

        $res = $this->db->execute_query('SHOW columns FROM ' . $this->table);
        foreach ($res as $col) {
            $this->columns[]     = $col['Field'];
            $this->$col['Field'] = null;
            if ($col['Key'] == 'PRI') {
                $this->primary_key = $col['Field'];
            }
        }

    }

    public function getPrimaryKey()
    {
        return $this->primary_key;
    }

    public function getColumns()
    {
    	return $this->columns;
    }

    public function first()
    {
        $res = $this->db->execute_query('SELECT * FROM ' . $this->table . ' limit 1');
        if ($res) {
            foreach ($this->columns as $key) {
                $this->$key = $res[0][$key];
            }
        }
        return $this;

    }

    public function last()
    {
        $res = $this->db->execute_query('SELECT * FROM ' . $this->table . ' ORDER BY ' . $this->primary_key . ' DESC limit 1');
        if ($res) {
            foreach ($this->columns as $key) {
                $this->$key = $res[0][$key];
            }
        }
        return $this;

    }

    private function factory($query)
    {
        $obj = [];
        $res = $this->db->execute_query($query);
        if ($res) {
            foreach ($res as $row) {
                $o = new $this->className();
                foreach ($this->columns as $key) {
                    $o->$key = $row[$key];
                }
                $obj[] = $o;
            }
        }

        return $obj;
    }

    public function getAll()
    {
        return $this->factory('SELECT * FROM ' . $this->table);
    }

    public function find($where, $limit = '')
    {
        if ($limit == '') {
            return $this->factory('SELECT * FROM ' . $this->table . ' WHERE ' . $where);
        } else {
            return $this->factory('SELECT * FROM ' . $this->table . ' WHERE ' . $where . ' LIMIT ' . $limit);
        }

    }

    public function get($key)
    {
        $res = $this->db->execute_query('SELECT * FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = ' . $key);
        if ($res) {
            foreach ($this->columns as $key) {
                $this->$key = $res[0][$key];
            }
        }
        return $this;
    }

    public function update()
    {

        $data = [];
        foreach ($this->columns as $key) {
            if ($key != $this->primary_key) {
                $data[$key] = $this->$key;
            }

        }
        $primary_key = $this->primary_key;

        $this->db->update_record($this->table, $primary_key, $this->$primary_key, $data);

        if ($this->db->num_rows()) {
            return true;
        }
        return false;
    }

    public function save($pk_auto=true)
    {
    	$data = [];
        foreach ($this->columns as $key) {
            if ($pk_auto) {
	            if ($key != $this->primary_key) {
	            	if ($this->$key != null) {
	                	$data[$key] = $this->$key;	            		
	            	}
	            }
            }else{
            	 if ($this->$key != null) {
	                 $data[$key] = $this->$key;	            		
	             }
            }

        }
        $primary_key = $this->primary_key;

        $this->db->insert_Record($this->table, $data);

        if ($this->db->num_rows()) {
            return true;
        }
        return false;
    }

}
