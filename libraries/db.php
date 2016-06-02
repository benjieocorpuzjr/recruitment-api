<?php



/**
 * CORE DB
 * 
 * Core DB that can be call on other cores and main controller and backend.
 * This will keep all db call uniformed. all methods here should be use accordingly incase I miss something let us discuss and make some additional or adjustments
 *
 * @author: bcorpuzjr
 **/



class db {
	private static $instance;
    private static $params;
	private $dbc;
	private $status = 0;
	private $statement; // incase a developer need to . currently not used.

    protected function __construct($params) {
        $this->status = 0;
        $this->dbc = new mysqli($params['host'], $params['user'], $params['password'], $params['db']);

        if (!$this->dbc->connect_error) {
             $this->status = 1;
        }
    }



    public static function getInstance($params) {
		if (!isset(self::$instance) || self::$params != serialize($params)) {
            self::$params = serialize($params);
            $c = __CLASS__;
            self::$instance = new $c($params);
        }

        return self::$instance;
    }



    public function getStatus() {
    	return $this->status;
    }



    private function fetch($sql = "", $types = FALSE, $params = FALSE, $is_multiple) {
    	if(empty($sql)) {
    		echo "SQL statement is required";
    		return FALSE;
    	}

    	if($types && $params) {
	    	$where_params = array();
			$bind_params = array();

			if($params && count($params) > 0) {
				$bind_params[] = $types;
				foreach($params as &$param) {
					$bind_params[] = &$param;
				}
			}
		}

		$statement = $this->dbc->prepare($sql);

		if($this->dbc->error) { echo $this->dbc->error; return FALSE; } 
		if(!empty($statement->error)) { echo $statement->error; return FALSE; }
		if($types && $params) call_user_func_array(array($statement, 'bind_param'), $bind_params);

		$statement->execute();
		$result = $this->bind_array($statement, $is_multiple);
		return $result;
    }



	public function fetchRow($sql = "", $types = FALSE, $params = FALSE) {
		$result = $this->fetch($sql, $types, $params, FALSE);
		return $result;
	}



	public function fetchAll($sql = "", $types = FALSE, $params = FALSE) {
		$result = $this->fetch($sql, $types, $params, TRUE);
		return $result;
	}



	private function bind_array($stmt, $is_multiple) {
	    // Get metadata for field names
	    $meta = $stmt->result_metadata();

	    // initialise some empty arrays
	    $fields = $results = array();

	    // This is the tricky bit dynamically creating an array of variables to use
	    while ($field = $meta->fetch_field()) { 
	        $var = $field->name; 
	        $$var = null; 
	        $fields[$var] = &$$var; 
	        $fieldNames[] = $var;
	    }

	    $fieldCount = count($fieldNames);

		// Bind Results                                     
		call_user_func_array(array($stmt,'bind_result'),$fields);

		$i=0;
		while ($stmt->fetch()){
			if(!$is_multiple) {
				for($l=0;$l<$fieldCount;$l++) $results[$fieldNames[$l]] = $fields[$fieldNames[$l]];
				return $results;
			} else {
			    for($l=0;$l<$fieldCount;$l++) $results[$i][$fieldNames[$l]] = $fields[$fieldNames[$l]];
			}
		    $i++;
		}

		if(count($results) == 0) return FALSE;
		return $results;
	}



	public function insert($table, $types = FALSE, $params = array(), $get_last_key = FALSE) {
		$id = 0;
		if(empty($table) || !$types || count($params) == 0) {
			echo "All parameters are required";
    		return FALSE;
    	}

    	$sql = "INSERT INTO ".$table."(".implode(',', array_keys($params)).")";
		$bind_params = array();
		$markers = array();
		$sql .= ' VALUES ( ';
		$bind_params[] = $types;

		foreach($params as &$param) {
			$markers[] = "?";
			$bind_params[] = &$param;
		}

		$sql .= implode(',', $markers).")";
		$statement = $this->dbc->prepare($sql);

		if($this->dbc->error) { echo $this->dbc->error; return FALSE; }
		if(!empty($statement->error)) { echo $statement->error; return FALSE; }
		if($types && $params) call_user_func_array(array($statement, 'bind_param'), $bind_params);

		if($statement->execute()) {
			if($get_last_key) {
				$id = $statement->insert_id;
			}

			$statement->close();
			return $id;
		} else {
			$statement->close();
			echo "Error: ".$this->dbc->error;
			return FALSE;
		}
	}



	// public function insertBatch($table, $types = FALSE, $params = FALSE) {

	// 	$array_error_insert = array();

	// 	if(empty($table)) {

	// 		echo "Table name is required";

 //    		return FALSE;

 //    	}



 //    	// if(!$other_values) {

 //    	// 	echo "Please use insert instead of insertbatch";

 //    	// 	return FALSE;

 //    	// }





 //    	$sql = "INSERT INTO ".$table."(".implode(',', $array_keys($params)).")";



 //    	if($types && $params) {

	// 		// $bind_params = array();

	// 		$markers = array();



	// 		if($params && count($params) > 0) {

	// 			$sql .= ' VALUES ( ';

	// 			// $bind_params[] = $types;



	// 			foreach($params as $index => &$param) {

	// 				$markers[] = "?";

	// 				// $bind_params[] = &$param;

	// 			}



	// 			$sql .= implode(',', $markers).")";

	// 		}

	// 	}



	// 	$bind_params[] = $types;

	// 	foreach($params as $index => $data) {

	// 		$bind_params[$index] = $data;

	// 	}



	// 	$statement = $this->dbc->prepare($sql);



	// 	if($this->dbc->error) return $this->dbc->error;

	// 	if(!empty($statement->error)) return $statement->error;

	// 	if($types && $params) call_user_func_array(array($statement, 'bind_param'), $bind_params);



	// 	foreach($other_values) {

	// 		if($statement->execute()) {

	// 			$array_error_insert['']

	// 		}

	// 	}



	// 	if($statement->execute()) {

	// 		return TRUE;

	// 	} else {

	// 		echo "Error: ".$this->dbc->error;

	// 		return FALSE;

	// 	}

	// }



	public function update($sql, $types = FALSE, $params = array()) {

		if(empty($sql)) {

    		echo "SQL statement is required";

    		return FALSE;

    	}



    	if($types && $params) {

			$bind_params = array();



			if($params && count($params) > 0) {

				$bind_params[] = $types;

				foreach($params as &$param) {

					$bind_params[] = &$param;

				}

			}

		}



		$statement = $this->dbc->prepare($sql);



		if($this->dbc->error) { echo $this->dbc->error; return FALSE; } 

		if(!empty($statement->error)) { echo $statement->error; return FALSE; }

		if($types && $params) call_user_func_array(array($statement, 'bind_param'), $bind_params);



		if($statement->execute()) {

			return TRUE;

		} else {

			return FALSE;

		}

	}



	public function get_last_id() {

		return;

	}



	public function delete() {

		

	}

}