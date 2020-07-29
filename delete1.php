<html>
<head>
	<title>Delete Player</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="https://images3.alphacoders.com/212/212835.jpg" text="Black" link="Black" vlink="Red">


<?php 
$host = "localhost"; 
$user = "db1u19"; 
$pass = "mo6l1r9a"; 
$db = $user; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
	or die ("Could not connect to server\n"); 

$query = "SELECT * FROM PLAYERS"; 

$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");
	
if(isset($_POST['submit'])) {
	$firstname = pg_escape_string($_POST['firstname']);
	$lastname = pg_escape_string($_POST['lastname']);
	if(!$firstname){
		echo "<p align='center'>You forgot to put firstname!</p>";
	}else if(!$lastname){
		echo "<p align='center'>You forgot to put lastname!</p>";
	}else{
	$res = pg_query($con, "select players_code from PLAYERS where firstname='$firstname' AND lastname='$lastname'");
	$playerid = pg_fetch_row($res);
	$pg = "DELETE FROM PLAYERS WHERE firstname=('$firstname')AND lastname=('$lastname')"; 
	$result = pg_query($con, $pg) or die("Error in SQL query: " . pg_last_error());
	$pg2 = "DELETE FROM OWNS WHERE players_code=('$playerid[0]')"; 							 //διαγραφη παικτη απο owns
	$result = pg_query($con, $pg2) or die("Error in SQL query: " . pg_last_error());
	}
 }
	
pg_close($con); 
?>

<div>

<h1 align="center">Delete Player</h1>
	
	<form align="center" action="delete1.php" method="post">
	<table align="center">
	
	<tr><td>FIRSTNAME:</td>
	<td><input type="" name="firstname"></td></tr>
	
	<tr><td>LASTNAME:</td>
	<td><input type="" name="lastname"></td></tr>
	
	
	</table>
	<p align = "center">
 	<input type="submit" name="submit" value="Submit" style="height:50px; width:140px;"> 
	</p></form>
	
	<form action="index.html" method="post">
	<p align = "center">
 	<button style="height:30px; width:140px; font-size:75%">Home</button>
	</form>
	<form action="delete.php" method="post">
	<input type="image" src="minicons-28-512.png" alt="Submit" width="48" height="48">
	</form>
</div>
	
</body>
</html>
