<?php
	require_once("support.php");	

	$host = "localhost";
	$user = "dbuser";
	$password = "goodbyeWorld";
	$database = "groupproj";
	$table = "reviews";
    $db_connection = new mysqli($host, $user, $password, $database);
	
	$fileToRetrieve = $_GET["fileToRetrieve"];	
	$sqlQuery = "select image, docMimeType from $table where docName = '{$fileToRetrieve}'";
	$result = $db_connection->query($sqlQuery);
	if ($result) {
		$recordArray = mysqli_fetch_assoc($result);
		header("Content-type: "."{$recordArray['docMimeType']}");
		echo $recordArray['image'];
		mysqli_free_result($result);
	} else { 				   ;
		$body = "<h3>Failed to retrieve document $fileToRetrieve: ".mysqli_error($db)." </h3>";
	}
		
	/* Closing */
	mysqli_close($db);
	
	echo generatePage($body);

function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>
