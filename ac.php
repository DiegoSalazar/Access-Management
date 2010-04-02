<?php 
$con = mysql_connect('localhost', 'root', 'deenies01*');
if (!$con) echo mysql_error();
mysql_select_db('deeniesdb');

$q = strtolower($_GET["q"]); //search term as passed in by autocomplete
if (!$q) return;
$data = array();

//build a query to search for members or partners where first name or last name LIKE $q
$sql = "SELECT mem_id, fname, lname";
$sql .= " FROM member_info";
$sql .= " WHERE fname LIKE '%{$q}%' OR lname LIKE '%{$q}%'";
$sql .= " ORDER BY fname, lname";

$result = mysql_query($sql) or die('Search for member info failed: '.mysql_error());

while ($row = mysql_fetch_assoc($result)) {
	$data[$row['mem_id']] = $row['fname'] . ' '. $row['lname'];	
}

$sql2 = "SELECT mem_id, fname, lname";
$sql2 .= " FROM partners_info";
$sql2 .= " WHERE fname LIKE '%{$q}%' OR lname LIKE '%{$q}%'";
$sql2 .= " ORDER BY fname, lname";

$result2 = mysql_query($sql2) or die('Search for partner info failed: '.mysql_error());

while ($row = mysql_fetch_assoc($result2)) {
	$data[$row['mem_id']] = $row['fname'] . ' '. $row['lname'];	
}

//echo "<pre>"; print_r($data); echo "<hr>";

foreach ($data as $key => $val) {
	echo "$val-$key \n";	
}
?>