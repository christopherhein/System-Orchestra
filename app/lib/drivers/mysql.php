<?php
/**
* MySQL Connection File
*
* Easy to use MySQL Connection and ORM
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/database/mysql/
*
*/
require_once(ROOT.'/config/config.php');
require_once(ROOT.'/config/database.php');
require_once(ROOT.'/lib/framework/inflect.php');

class Database {
  protected $_handler;
  protected $_server;
  protected $_user;
  protected $_password;
  protected $_database;
  protected $_status;
	protected $_result;
  protected $_table;
  protected $_limit;
	protected $_has_many = array();
	protected $_belongs_to = array();
	protected $_has_many_belongs_to = array();
	protected $_page;
	protected $_where_field;
	protected $_where_value;
	protected $_order_field;
	protected $_order;
	protected $_preceeding;
	protected $_offset;
	public $_new_id;
  
  public function __construct() {
    global $app;
    global $db;
    
    $this->_server    = $db[$app['status']]['server'];
    $this->_user      = $db[$app['status']]['user'];
    $this->_password  = $db[$app['status']]['password'];
    $this->_database  = $db[$app['status']]['name'];
    $this->status     = 0;
		$this->clear();
  }
  
  public function __call($name, $arguments) {
    if (substr($name, 0, 8) == 'find_by_') {
      $property = substr($name, 8);
      $this->_where_field = $property;
      $this->_where_value = $arguments[0];
      return $this->find();
    } elseif($name == "new") {
      $this->new_item();
      return $this;
    }
  }

	public function table($table) {
		$this->_table = $table;
		return $this;
	}
  
	/* If it has many
			If there is anything that needs to be displayed from other tables
	*/
	public function hasmany($has_many, $options = array()) {
		$this->_has_many[] = $has_many;
		return $this;
	}
	
	public function belongs_to($belongs_to, $options = array()) {
		$this->_belongs_to[] = $belongs_to;
		return $this;
	}
	
	public function has_many_belongs_to($has_many, $belongs_to) {
		$this->_has_many_belongs_to[$has_many] = $belongs_to;
		return $this;
	}
	
	public function get_hasmany() {
    if($this->_has_many != array()) {
      return $this->_has_many;
    } else {
      return false;
    }
  }
  
  public function get_belongs_to() {
    if($this->_belongs_to != array()) {
      return $this->_belongs_to;
    } else {
      return false;
    }
  }
  
  public function get_has_many_belongs_to() {
    if($this->_has_many_belongs_to != array()) {
      return $this->_has_many_belongs_to;
    } else {
      return false;
    }
  }
	
	/* Page number it's on
			When listing in pagination
	*/
	public function page($num) {
		$this->_page = $num;
		return $this;
	}
  
	/* What you want to find by
			Where limiter
	*/
	public function where($value, $field = 'id') {
		$this->_where_field = $field;
		$this->_where_value = $value;
		return $this;
	}
	
	/* Order In Which they are returned
			How you want the fields to be returned
	*/
	public function order($field, $order = "ASC") {
		$this->_order_field = $field;
		$this->_order = $order;
		return $this;
	}
	
	/* Limit for the return
			How many fields do you want returned
	*/
	public function limit($num) {
		$this->_limit = $num;
		return $this;
	}
	
	public function paginate($num=NULL, $page=NULL) {
	  global $app;
	  global $page_num;
	  global $core;
	  extract($core);
	  
	  if($num == NULL) {
	    $num = $app['pagination'];
	  }
	  if($page == NULL) {
	    $page = $page_num;
	  }
	  
	  $this->connect();
	  $sql = "SELECT * FROM ".$this->_database.".".$this->_table;
	  $run = mysql_query($sql);
	  $num_of_rows = mysql_num_rows($run);
	  $pagination->build($num_of_rows);
	  $this->disconnect();
	  
	  $this->_offset = $num*($page-1);
	  $this->_limit = $num;
	  return $this;
	}

  /* Connection
      Gaining access to the database to run querys
  */
  private function connect($persistant = false) {
    if($persistant == true) {
      $this->_handle = mysql_pconnect($this->_server, $this->_user, $this->_password);
    } else {
      $this->_handle = mysql_connect($this->_server, $this->_user, $this->_password);
    }
    if(!$this->_handle) {
      $hooks->generate_error("MySQL Connection Error, using: ".$this->server." :: ".$this->_user." :: ".$this->_password, "500.php", E_USER_ERROR);
    } else {
      $this->_status = 1;
      return $this->_handle;
    }
  }
  
  /* Disconnection
      Kill the connection to the database
  */
  private function disconnect() {
    $this->_status = 0;
    mysql_close($this->_handle);
    return true;
  }

	/* Create Table
      Run the is with an array of options to create tables
  */
	public function up($db, $items) {
		$this->connect();
		$sql = "CREATE TABLE ".$this->_database.".".$db." (";
		$sql .= "id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
		foreach($items as $i) {
			$rm = split(" => ", $i);
			switch($rm[0]) {
				case 'string':
					$sql .= "".$rm[1]." VARCHAR(255) NOT NULL, ";
				break;
				case 'text':
					$sql .= "".$rm[1]." TEXT NOT NULL, ";
				break;
				case 'int':
					$sql .= "".$rm[1]." BIGINT NOT NULL, ";
				break;
			}
		}
		$sql .= "created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00', updated_at TIMESTAMP NOT NULL DEFAULT now() on update now()";
		$sql .= ");";
		$run = mysql_query($sql);
		if($run) { return true; } else { return false; }
		$this->disconnect();
	}
	
	/* Drop Table
      Run the is with a table name to drop the table
  */	
	public function down($table) {
		$this->connect();
		$sql = "DROP TABLE ".$this->_database.".".$table.";";
		$run = mysql_query($sql);
		if($run) { return true; } else { return false; }
		$this->disconnect();
	}
	
	
  public function new_item() {
    $this->connect();
    $select = "SELECT * FROM ".$this->_database.".".$this->_table." ORDER BY id DESC;";
    $srun = mysql_query($select);
    $num_fields = mysql_num_fields($srun) - 3;
    $val = "";
    for($i = 0; $i < $num_fields; ++$i) {
      $val .= " '',";
    }
		$sql = "INSERT INTO ".$this->_database.".".$this->_table." VALUES ( NULL,".$val." NULL, NULL);";
    $run = mysql_query($sql);
    $select = "SELECT * FROM ".$this->_database.".".$this->_table." ORDER BY id DESC LIMIT 1;";
    $srun = mysql_query($select);
    $row = mysql_fetch_assoc($srun);
    $this->_new_id = $row['id'];
		$this->disconnect();
    return $this;
  }
	
	/* Find
			Select Fields using the variables passed in.
	*/
	public function find($howMany = 'all') {
		$sql = "SELECT * FROM ".$this->_database.".".$this->_table;
		if($this->_where_field != NULL && $this->_where_value != NULL) {
		  if($this->_where_field == "id") {
		    $sql .= " WHERE $this->_table.$this->_where_field=".$this->_where_value;
		  } else {
		   $sql .= " WHERE $this->_table.$this->_where_field='".$this->_where_value."'";
		  }
		}
		if($this->_order_field != NULL) {
			$sql .= " ORDER BY $this->_order_field $this->_order";
		}
		if($this->_limit != NULL) {
			$sql .= " LIMIT $this->_limit";
		}
		if($this->_offset != NULL) {
		  $sql .= " OFFSET $this->_offset";
		}
		$sql .= ";";
		$this->connect();
		if($howMany == 'all') {
      return $this->run($sql);
		} else {
		  return $this->run($sql, $howMany);
		}
		$this->disconnect();
	}
	
	/* Create
      Create new rows in the table
			-- Schema $db->create('${TABLE}', array('${FIELD}' => '${VALUE}'));
  */
  public function create($fields, $table = NULL) {
    if($table != NULL) {
      $this->_table = $table;
    }
		if($fields != NULL) {
		  if(isset($fields['submit'])) {
		    unset($fields['submit']); 
		  }
			$this->connect();
			$values = "";
			foreach($fields as $f) {
				$values .= "'".mysql_real_escape_string($f)."', ";
			}
			$sql = "INSERT INTO ".$this->_database.".".$this->_table." VALUES ( NULL, ".$values." NULL, NULL);";
      $run = mysql_query($sql);
      if($run) { return true; } else { return false; }
			$this->disconnect();
		}
  }
  
	/* Update
      Update new rows in the table
  */
  public function save($fields) {
    $inflection = New Inflect();
    global $app;
		if($fields != NULL) {
		  if($fields['orch-token'] == $app['orch-token']) {
		    unset($fields['orch-token']);
		    if(isset($fields[$inflection->singularize($this->_table)]['id'])) {
  		    $id = $fields[$inflection->singularize($this->_table)]['id'];
    			unset($fields[$inflection->singularize($this->_table)]['id']);
  		  } else {
  		    if(isset($fields[$inflection->singularize($this->_table)]['id'])) {
  		      unset($fields[$inflection->singularize($this->_table)]['id']);
  		    }
  		    $id = $this->_new_id;
  		  }
  			$this->connect();
  			unset($fields[$inflection->singularize($this->_table)]['submit']);
  			$this->connect();
  			$values = "";
  			while(list($k, $v) = each($fields[$inflection->singularize($this->_table)])) {
  			  if(!is_numeric($v)) {
  				  $values .= "$k='".mysql_real_escape_string($v)."', ";
  			  } else {
  			    $values .= "$k=".$v.", ";
  			  }
  			}
  			$sql = "UPDATE ".$this->_database.".".$this->_table." SET $values updated_at=NULL WHERE id = ".$id.";";
        $run = mysql_query($sql);
        if($run) { return true; } else { return false; }
  			$this->disconnect();
  			$this->clear();
			}
		}
  }
  
  public function build($params) {
    $inflection = New Inflect();
    $this->connect();
    if($this->_has_many != array()) {
      foreach($this->_has_many as $many) {
        if(isset($params[$many])) {
          $col = "";
          $val = "";
          $i = 0;
          $id = $this->_new_id+1;
          while(list($k, $v) = each($params[$many])) {
            if($i == 0) {
              $col .= $inflection->singularize($this->_table)."_id, $k";
              $val .= $id.", '$v'";
            } else {
              $col .= ", $k";
              $val .= ", '$v'"; 
            }
            $i++;
          }
          $sql = "INSERT INTO ".$this->_database.".".$many." ($col) VALUES ($val);";
          $run = mysql_query($sql);  
        }
      }
    }
    if($this->_has_many_belongs_to != array()) {
      while(list($k, $v) = each($this->_has_many_belongs_to)) {
        $select = "SELECT * FROM ".$this->_database.".".$v." ORDER BY id DESC LIMIT 1;";
        $run = mysql_query($select);
        $row = mysql_fetch_assoc($run);
        $val = "";
        $ids = "";
        $i = 0;
        while(list($c, $va) = each($params[$v])) {
          $id = $row['id']++;
          if($i == 0) {
            $val .= "NULL, '$va', NULL, NULL";
            $ids .= "NULL, $this->_new_id, ".$id.", NULL, NULL";
          } else {
            $val .= "),(NULL, '$va', NULL, NULL"; 
            $ids .= "),(NULL, $this->_new_id, ".$id.", NULL, NULL";
          }
          $i++;
        }
        $sql = "INSERT INTO  ".$this->_database.".".$v." VALUES ($val);";
        $sql2 = "INSERT INTO  ".$this->_database.".".$k." VALUES ($ids);";
        $query = mysql_query($sql);
        $query2 = mysql_query($sql2);
      }
    }
    $this->disconnect();
    return $this;
  }

  /* Delete
      Delete Rows in a table
			-- Schema $db->destroy('${TABLE}', '${VALUE}');
  */
  public function destroy($id, $where = 'id') {
		if($id != NULL) {
  		$this->connect();
			if($id == 'all') {
				$sql = "DELETE FROM ".$this->_database.".".$this->_table.";";
			} else {
				if($where != 'id') { $id = "'".$id."'"; }
				$sql = "DELETE FROM ".$this->_database.".".$this->_table." WHERE $where = $id;";
			}
      $run = mysql_query($sql);
      if($run) { return true; } else { return false; }
			$this->disconnect();
		} 
  }

	public function run($query, $singleResult = 0) {
	  $inflection = New Inflect();
	  
		$this->_result = mysql_query($query);
    if(preg_match('/select/i', $query)) {
      $result = array();
  		$table = array();
  		$field = array();
  		$temp_results = array();
      $num_fields = mysql_num_fields($this->_result);
  		for ($i = 0; $i < $num_fields; ++$i) {
  			array_push($table, mysql_field_table($this->_result, $i));
  	  	array_push($field, mysql_field_name($this->_result, $i));
  		}
  		
      while($row = mysql_fetch_row($this->_result)){
        for($i = 0; $i < $num_fields; ++$i) {
          $table[$i] = $inflection->singularize($table[$i]);
          $temp_results[$table[$i]][$field[$i]] = stripslashes($row[$i]); 
        }
        array_push($result, $temp_results);
      }
      if($this->_has_many != array()) {
        foreach($this->_has_many as $many) {
          $sql = "SELECT * FROM ".$this->_database.".".$many;
          $run = mysql_query($sql);
          while($row = mysql_fetch_assoc($run)) {
            $tbl = $inflection->singularize($this->_table);
            for($i = 0; $i < count($result); ++$i) {
              if($result[$i][$tbl]['id'] == $row[$tbl."_id"]) {
                if(!is_array($row)) {
                  $result[$i][$tbl][$many][] = stripslashes($row); 
                } else {
                  $result[$i][$tbl][$many][] = $row; 
                }
              }
            }
          }
        }
      }
      if($this->_has_many_belongs_to != array()) {
        while(list($k, $v) = each($this->_has_many_belongs_to)) {
          $sql = "SELECT * FROM ".$this->_database.".".$k." LEFT JOIN ".$this->_database.".".$v." ON ".$k.".".$inflection->singularize($v)."_id = ".$v.".id;";
          $query = mysql_query($sql);
          while($row = mysql_fetch_assoc($query)) {
            $tbl = $inflection->singularize($this->_table);
            for($i = 0; $i < count($result); ++$i) {
              if($result[$i][$tbl]['id'] == $row[$tbl."_id"]) {
                $result[$i][$tbl][$v][] = stripslashes($row);
              }
            }
          }
        }
      }
      mysql_free_result($this->_result);
      $this->clear();
      if(count($result) == 1) {
        return $result[0];
      } else {
        return $result;
      }
    }
	}
	
	public function clear() {
	  $inflection = New Inflect();
	  
		$this->_result = NULL;
	  $this->_limit = NULL;
	  $this->_offset = NULL;
		$this->_has_many = array();
		$this->_belongs_to = array();
		$this->_has_many_belongs_to = array();
		$this->_page = NULL;
		$this->_where_field = NULL;
		$this->_where_value = NULL;
		$this->_order_field = NULL;
		$this->_order = NULL;
		$this->_new_id = NULL;
		$this->_table = strtolower($inflection->pluralize(get_called_class()));
	}

}