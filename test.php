<?php
$login = 'arm';
$pass = '123';

if(($_SERVER['PHP_AUTH_PW']!= $pass || $_SERVER['PHP_AUTH_USER'] != $login)|| !$_SERVER['PHP_AUTH_USER'])
{
    header('WWW-Authenticate: Basic realm="Test auth"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Auth failed';
    exit;
}
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "phppot_examples");

$filename = "toy_csv.csv";
$fp = fopen('php://output', 'w');

$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA='phppot_examples' AND TABLE_NAME='toy'";

$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_row($result)) {
	$header[] = $row[0];
}	

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$query = "SELECT * FROM toy";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_row($result)) {
	fputcsv($fp, $row);
}
exit;
?>