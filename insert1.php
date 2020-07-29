<html>
<head>
	<title>Insert Player</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<!-- http://zetcode.com/db/postgresqlphp/read/ -->

<body  background="http://eskipaper.com/images/grass-wallpaper-10.jpg" link="Blue" vlink="Red">
<?php 
$host = "localhost"; 
$user = "db1u19"; 
$pass = "mo6l1r9a"; 
$db = $user; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
	or die ("Could not connect to server\n"); 

$query = "SELECT * FROM PLAYERS";
$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");
if(isset($_POST['submit'])){
		$res = pg_query($con, "select * from  PLAYERS");   
		$playersrows = pg_numrows($res);
		$res2 = pg_query($con, "select max(players_code) from PLAYERS"); 
		$id= pg_fetch_row($res2);
		$id[0]++;
		$flag=0;
		$flag3=0;
		$firstname = pg_escape_string($_POST['firstname']);
		$lastname = pg_escape_string($_POST['lastname']);
		$teamname = pg_escape_string($_POST['teamname']);
		$res7 = pg_exec($con, "select * from  Teams");  
		$teamsrows = pg_numrows($res7);
		
		for($i=0; $i<$teamsrows; $i++){					//ελεγχος team αν υπαρχει στο TEAMS
			$row = pg_fetch_row($res7);
			$row[1] = trim($row[1]);
			$teamname = trim($teamname);
			if(strcmp($row[1],$teamname)==0){
				$flag3=1;
			}
		}
		
		$position = pg_escape_string($_POST['position']);
		$nation = pg_escape_string($_POST['nation']);
		$age = pg_escape_string($_POST['age']);
		$pace = pg_escape_string($_POST['pace']);
		$dribbling = pg_escape_string($_POST['dribbling']);
		$shooting = pg_escape_string($_POST['shooting']);
		$defending = pg_escape_string($_POST['defending']);
		$passing = pg_escape_string($_POST['passing']);
		for($i=0; $i < $playersrows; $i++){
			$row = pg_fetch_row($res);
			$row[1]= trim($row[1]);
			$row[2]= trim($row[2]);
			$firstname= trim($firstname);
			$lastname= trim($lastname);				
			
			if(strcmp($row[1],$firstname)==0&&strcmp($row[2],$lastname)==0){		//Elegxos sto name gia diploeggrafes
				$flag=1;
			}
		}
		if($flag==0 && $flag3==1){		
			$query = "INSERT INTO PLAYERS(players_code,firstname,lastname,position,nation,age,pace,dribbling,shooting,defending,passing) VALUES('$id[0]','$firstname','$lastname','$position','$nation','$age','$pace','$dribbling','$shooting','$defending','$passing')";
			$result=pg_query($con,$query) or die("Error in SQL query: " . pg_last_error());
			$res4 = pg_query($con, "select team_code from TEAMS where name='$teamname'"); 
			$row = pg_fetch_row($res4);
			$query2 = "INSERT INTO OWNS (players_code,teams_code) VALUES ('$id[0]','$row[0]')";
			$result=pg_query($con,$query2) or die("Error in SQL query: " . pg_last_error());
		}elseif($flag3==0){
				echo "<p align='center'>Team doesnt exist insert team first or check teamname</p>";
		}
		else{
			echo " Ο Ποδοσφαιριστής υπάρχει ήδη!";
		}
		
		
				
		
}		
pg_close($con); 
?>

<div >

<h1 align="center">Insert Player</h1>	
	<form align="center" action="insert1.php" method="post">
	<table align="center">
	
	<tr><td>FIRSTNAME:</td>
	<td><input type="" name="firstname" maxlength="25"></td></tr>
	
	<tr><td>LASTNAME:</td>
	<td><input type="" name="lastname" maxlength="25"></td></tr>
	
	<tr><td>TEAMNAME:</td>
	<td><input type="" name="teamname" maxlength="25"></td></tr>
	
	<tr><td>POSITION:</td>
	<td><input type="" name="position" maxlength="30"></td></tr>	
	
	<tr><td>NATION:</td>
	<td><input type="" name="nation" maxlength="25"></td></tr>
	
	<tr><td>AGE:</td>
	<td><input type="number" name="age" min="0" max="100"></td></tr>
	
	<tr><td>PACE:</td>
	<td><input type="number" name="pace" min="0" max="100"></td></tr>
	
	<tr><td>SHOOTING:</td>
	<td><input type="number" name="shooting" min="0" max="100"></td></tr>
	
	<tr><td>PASSING:</td>
	<td><input type="number" name="passing" min="0" max="100"></td></tr>
	
	<tr><td>DRIBBLING:</td>
	<td><input type="number" name="dribbling" min="0" max="100"></td></tr>
	
	<tr><td>DEFENDING:</td>
	<td><input type="number" name="defending" min="0" max="100"></td></tr>
	
	
	</table>
	
	<p align = "center"><input type="submit" name="submit" value="Submit" style="height:50px; width:140px;">
	</p>	</form>
	
	
	<form action="index.html" method="post">
	<p align = "center">
 	<button style="height:30px; width:140px; font-size:75%">Home</button>
	</form>
	<form action="delete1.php" method="post">
	<p align = "center"><button style="height:30px; width:140px; font-size:75%">Go to delete Player</button></p>
	</form>
	<form action="insert2.php" method="post">
	<p align = "center"><button style="height:30px; width:140px; font-size:75%">Insert Team</button></p>
	</form>
	<form action="insert.php" method="post">
 	<input type="image" src="minicons-28-512.png" alt="Submit" width="48" height="48">
	</form>


</div>
</body>
</html>