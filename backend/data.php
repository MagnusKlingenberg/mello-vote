<?php
require("config.php");
$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);


/* check connection */
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}

$voter = $mysqli->real_escape_string($_GET['voter']);

$votes = [];

$responce = new stdClass();
$responce->list = [];
$responce->name = "";
$rows = [];
/* Select queries return a resultset */
$result = $mysqli->query("SELECT voter, name, votes FROM mello_voters WHERE voter = '$voter'");
if (false === $result) {
	printf(json_encode($responce));
	exit(0);
}

if ($result->num_rows == 0) {
	$responce->name = 'Fuskis';
	$obj = new stdClass();
	$obj->id = 'fusk';
	$obj->name = 'No Votes For you!';
	$obj->flag = '';
	$responce->list[] = $obj;
	printf(json_encode($responce));
	exit(0);
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
foreach ( $rows as $row ) {
	$votes = json_decode($row['votes']);
	$responce->name = $row['name'];
}


if (empty($votes)) {
	foreach ($template as $tmp) {
		$obj = new stdClass();
		$obj->id = $tmp['id'];
		$obj->name = $tmp['name'];
		$obj->flag = $tmp['flag'];
		$responce->list[] = $obj;
	}
} else {
	foreach ($votes as $vote) {
		$obj = new stdClass();
		$obj->id = $template[$vote]['id'];
		$obj->name = $template[$vote]['name'];
		$obj->flag = $template[$vote]['flag'];
		$responce->list[] = $obj;
	}
}

printf(json_encode($responce));
