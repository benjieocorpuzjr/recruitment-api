<?php
$a = 'samp';
$b = 'query';

$sql = 'SELECT * FROM sample_table';
$types = 'ss';
$params = array(
	'samp_name' => 'samp',
	'samp' => 'query',
);

$e_params = array(
	'samp',
	'query',
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
$where_params = array();
$bind_params = array();

if($params && count($params) > 0) {
	$sql .= ' WHERE ';
	$bind_params[] = $types;
	foreach($params as $index => &$param) {
		$where_params[] = $index.'=?';
		$bind_params[] = &$param;
	}

	$where_clause = implode(' AND ', $where_params);
	$sql .= $where_clause;
}
echo $sql."<br /><br />";

$statement = $dbc->prepare($sql);

if(!$dbc->error) {
	echo 'statement clean';
} else {
	echo $dbc->error;
}


// $bind_names[] = $types;
// for ($i=0; $i<count($e_params);$i++) 
// {
//     $bind_name = 'bind' . $i;
//     $$bind_name = $e_params[$i];
//     $bind_names[] = &$$bind_name;
// }


// $return = call_user_func_array(array($stmt,'bind_param'),$bind_params);

// $statement->bind_param('ss', $a, $b);
// print_r($bind_params);
// print_r($bind_names);
if(empty($statement->error)) {
	echo 'no error';
} else {
	echo $statement->error;
}

call_user_func_array(array($statement, 'bind_param'), $bind_params);

$statement->execute();





// $statement->bind_result($id);

// while($statement->fetch()) {
// 	echo $id;
// }


$result = $statement->get_result();
// print_r($result);
echo '<br />';
echo '<br />';

$row_return = array();
while($row = $result->fetch_array(MYSQLI_NUM)) {
	$row_return[] = $row;
	// foreach($row as $r) {
	// 	$row_return[] = $row;
	// }
	echo "<br />";
}

print_r($row_return);