<?php
require("config.php");

$input = json_decode(file_get_contents('php://input'), true);

$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}


$sql = sprintf("UPDATE mello_voters SET votes = '%s' where voter = '%s'",
               $mysqli->real_escape_string(json_encode($input['votes'])),
               $voter = $mysqli->real_escape_string($input['voter']));
print_r($sql);
$result = $mysqli->query($sql);
