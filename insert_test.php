<?php
$table = 'sample_table';
$types = 'ss';
$params = array(
	'samp_name' => 'inserted data',
	'samp' => 'second data',
);

$db_params = array(
	'host'  => 'localhost',
    'user'  => 'root',
    'pass'  => '',
    'name'  => 'kalakaar',
);

$dbc = new mysqli($db_params['host'], $db_params['user'], $db_params['pass'], $db_params['name']);
if(!$dbc->connect_error) {
	echo 'success';
} else {
	echo 'failed';
}
echo '<br />';

$sql = "INSERT INTO ".$table."(".implode(',', array_keys($params)).")";

if($types && $params) {
	$bind_params = array();
	$markers = array();

	if($params && count($params) > 0) {
		$sql .= ' VALUES ( ';
		$bind_params[] = $types;

		foreach($params as $index => &$param) {
			$markers[] = "?";
			$bind_params[] = &$param;
		}

		$sql .= implode(',', $markers).")";
	}
}

$statement = $dbc->prepare($sql);

if($dbc->error) echo $dbc->error;
if(!empty($statement->error)) echo $statement->error;
call_user_func_array(array($statement, 'bind_param'), $bind_params);

if($statement->execute()) {
	return TRUE;
} else {
	return "Error: ".$dbc->error;
}




exit();