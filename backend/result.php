<?php
require("config.php");
$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);


/* check connection */
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}

if (isset($_GET['reset'])) {
	$mysqli->query("UPDATE mello_voters set votes = ''");   
}

$points = [12, 10, 8, 7, 6, 5, 4, 3, 2, 1];
$results = [];
foreach ( $template as $tmp) {
	$results[$tmp['id']] = 0;
}

$result = $mysqli->query("SELECT votes FROM mello_voters");
$rows = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
foreach ( $rows as $row ) {
	$votes = json_decode($row['votes']);
	$pos = 0;
	if (empty($votes)) continue;
	foreach ($votes as $vote) {
		if (isset($points[$pos])) {
			$results[$vote] += $points[$pos];
			$pos++;
		}
	}
}

arsort($results);
//var_export($results);
?>
<html>
<head>
<meta charset="UTF-8">
<title>Resultat Mello 2018</title>
<link rel="stylesheet" href="../style.css">
<?php
if (isset($_GET['refresh'])) {
	printf("<meta http-equiv=\"refresh\" content=\"%d\">\n", $_GET['refresh']);
} ?>
</head>
<body>
<h1>Resultat Mello 2018</h1>
<table>
<tr><th class="small"></th><th class="small"></th><th class="rest"></th></tr>
<?php 
$pos = 1;
foreach ( $results as $key => $points ) {
	printf("<tr><td>%d</td><td>%s</td><td class=\"wide\">%s</td></tr>\n",
	       $pos,
	       $points,
	       $template[$key]['name']);
	$pos++;
}
?>
</table>
</body>
</html>
