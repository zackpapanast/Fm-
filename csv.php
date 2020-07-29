<html>
<head>
        <title>Insert from csv file</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<!-- http://zetcode.com/db/postgresqlphp/read/ -->

<body background="http://eskipaper.com/images/grass-wallpaper-10.jpg" text="White">
<?php
$host = "localhost";
$user = "db1u19";
$pass = "mo6l1r9a";
$db = $user;

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
        or die ("Could not connect to server\n");
		
$query = "SELECT * FROM PLAYERS";
$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");

$filehandler = fopen("./data/Θέσεις_Παιχτών.csv", "r");			//Εισαγωγή από θεσεις_παιχτων.csv σε πινακες για την τοποθετηση των θεσεων στους παικτες
fgets($filehandler);
$i=0;
while ($line = fgets($filehandler)){
	$array = explode(",", $line);	
	$thesiid[$i] = $array[1];
	$thesiname[$i] = $array[0];
	$i++;
}
$thesirows =$i;
$filehandler = fopen("./data/Παίχτες.csv", "r");			//Εισαγωγή από παιχτες.csv σε PLAYERS
fgets($filehandler);
$id[0]=0;
$id[0]++;
while ($line = fgets($filehandler)){
	$array = explode(",", $line);
	$array[1] =  pg_escape_string($array[1]);
	$array[0] = pg_escape_string($array[0]);
	$array[4] =  pg_escape_string($array[4]);
	$array[1] = trim($array[1]);
	$array[2] = trim($array[2]);
	for($i=0; $i< $thesirows; $i++){
		$thesiid[$i]= trim($thesiid[$i]);
		if(strcmp($array[2],$thesiid[$i])==0){
			$kris=$thesiname[$i];
		}
	}
	$query = "INSERT INTO PLAYERS(players_code,firstname,lastname,position,nation,age,pace,dribbling,shooting,defending,passing ) VALUES('$id[0]','$array[0]','$array[1]','$kris','$array[4]','$array[5]','$array[6]','$array[7]','$array[8]','$array[9]','$array[10]')";
	$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
	$id[0]++;
	echo "Εγγραφή Ολοκληρώθηκε: ";
	echo "$query <br>";
}
echo "<br>";
fclose($filehandler);

$query = "SELECT * FROM CHAMPIONSHIP";
$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");

$filehandler = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από αγωνες.csv σε CHAMPIONSHIP
fgets($filehandler);
$id[0]=0;
$id[0]++;
while ($line = fgets($filehandler)){	
	$flag=0;
	$array = explode(",", $line);	
	$res2 = pg_query($con, "select * from championship"); 
	$playsrows = pg_num_rows($res2 );	
	for($i=0; $i< $playsrows; $i++){
		$row= pg_fetch_row($res2);
		$array[0]=trim($array[0]);	
		$row[1]=trim($row[1]);
		if(strcmp($array[0],$row[1])==0){					
			$flag=1;
		}		
	}
	if($flag==0){
		$query = "INSERT INTO CHAMPIONSHIP(div_code,name ) VALUES('$id[0]', '$array[0]')";
		$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
		$id[0]++;
		echo "Εγγραφή Ολοκληρώθηκε: ";
		echo "$query <br>";
	}
}

echo "<br>";
fclose($filehandler);

$query = "SELECT * FROM STADIUM";
$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");

$filehandler = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από αγωνες.csv σε STADIUM
fgets($filehandler);
$id[0]=0;
$id[0]++;
while ($line = fgets($filehandler)){	
	$flag=0;
	$array = explode(",", $line);	
	$array[22] =  pg_escape_string($array[22]);
	$res2 = pg_query($con, "select * from stadium"); 
	$stadiumrows = pg_num_rows($res2 );	
	for($i=0; $i< $stadiumrows; $i++){
		$row= pg_fetch_row($res2);
		$array[22]=trim($array[22]);	
		$row[1]=trim($row[1]);
		$row[1] =  pg_escape_string($row[1]);
		if(strcmp($array[22],$row[1])==0){
			$flag=1;
		}		
	}
	if($flag==0){
		$query = "INSERT INTO STADIUM(stadium_code,name,capacity ) VALUES('$id[0]', '$array[22]', '$array[23]')";
		$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
		$id[0]++;
		echo "Εγγραφή Ολοκληρώθηκε: ";
		echo "$query <br>";
	}
}


$query = "SELECT * FROM TEAMS";
$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");

$filehandler = fopen("./data/Ονόματα_Ομάδων.csv", "r");			//Εισαγωγή από Ονόματα_Ομάδων.csv σε πινακα για να βρουμε τα id των συγκεκριμενων ομαδων
fgets($filehandler);
$i=0;
while ($line = fgets($filehandler)){	
	$array = explode(",", $line);	
	$chooseid[$i] = $array[1];
	$choosename[$i] = $array[0];
	$i++;
}
$chooserows =$i;
echo "<br>";
fclose($filehandler);

$filehandler2 = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγώνες.csv σε TEAM
fgets($filehandler2);
while ($line = fgets($filehandler2)){
	$array = explode(",", $line);
	for($y=0; $y< $chooserows; $y++){
		if(strcmp($array[2],$choosename[$y])==0){
			$res2 = pg_query($con, "select name from TEAMS where name='$array[2]'"); 
			if(pg_num_rows($res2)==0){
				$query = "INSERT INTO TEAMS(team_code,name) VALUES('$chooseid[$y]', '$array[2]')";
				$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
				echo "Εγγραφή Ολοκληρώθηκε: ";
				echo "$query <br>";
			}
		}
	}
}
echo "<br>";
fclose($filehandler2);

$filehandler2 = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγώνες.csv σε TEAM για τις υπολοιπες ομαδες
fgets($filehandler2);

$res2 = pg_exec($con, "select max(team_code) from TEAMS"); 
$id= pg_fetch_row($res2);
$id[0]++;
while ($line = fgets($filehandler2)){	
	$array = explode(",", $line);
	$res2 = pg_query($con, "select name from TEAMS where name='$array[2]'"); 
	if(pg_num_rows($res2)==0){
		$query = "INSERT INTO TEAMS(team_code,name) VALUES('$id[0]', '$array[2]')";
		$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
		echo "Εγγραφή Ολοκληρώθηκε: ";
		echo "$query <br>";
		$id[0]++;
	}
}
echo "<br>";
fclose($filehandler2);

$filehandler2 = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγώνες.csv σε TEAM για την πολη και ετος ιδρυσης
fgets($filehandler2);

while ($line = fgets($filehandler2)){	
	$array = explode(",", $line);	
	$res2 = pg_query($con, "select * from TEAMS where  name='$array[2]'"); 
	$res=pg_query($con, "UPDATE TEAMS SET city='$array[19]', year_founded='$array[18]' where name='$array[2]'");
}
echo "<br>";
fclose($filehandler2);


$filehandler = fopen("./data/Παίχτες.csv", "r");			//Εισαγωγή από παιχτες.csv για ενημέρωση συσχέτισης owns
fgets($filehandler);
$result1 = pg_exec($con, "select * from players");
$playersrows = pg_numrows($result1);
$id[0]=0;
$id[0]++;
while ($line = fgets($filehandler)){
	$array = explode(",", $line);	
	for($i=0; $i< $playersrows; $i++){
		$array[3] = trim($array[3]);
		if(strcmp($array[3],$choosename[$i])==0){
			$query="INSERT INTO owns(players_code,teams_code) VALUES ('$id[0]','$chooseid[$i]')";
			$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
			$id[0]++;
			echo "Εγγραφή Ολοκληρώθηκε: ";
			echo "$query <br>";
		}
	}
}
echo "<br>";
fclose($filehandler);


$filehandler = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγωνες.csv για ενημέρωση συσχέτισης based
fgets($filehandler);

while ($line = fgets($filehandler)){	
	$array = explode(",", $line);	
	$array[22] =  pg_escape_string($array[22]);
	$res2 = pg_query($con, "select team_code from TEAMS where name='$array[2]'"); 
	$res = pg_query($con, "select stadium_code from STADIUM where name='$array[22]'");
	while ($row = pg_fetch_row($res2)) {
		$row2 = pg_fetch_row($res);
		$res3 = pg_query($con, "select team_code from BASED where stadium_code='$row2[0]'"); 
		if(pg_num_rows($res3)==0){
			$query = "INSERT INTO BASED(team_code,stadium_code) VALUES('$row[0]', '$row2[0]')";
			$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
			echo "Εγγραφή Ολοκληρώθηκε: ";
			echo "$query <br>";
		}
	}
}
echo "<br>";
fclose($filehandler);

$filehandler = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγωνες.csv για ενημέρωση συσχέτισης plays
fgets($filehandler);
while ($line = fgets($filehandler)){	
	$array = explode(",", $line);	
	$res2 = pg_query($con, "select team_code from TEAMS where name='$array[2]'"); 
	$res = pg_query($con, "select div_code from CHAMPIONSHIP where name='$array[0]'");
	while ($row = pg_fetch_row($res2)) {
		$row2 = pg_fetch_row($res);
		$res3 = pg_query($con, "select div_code from PLAYS where team_code='$row[0]'"); 
		if(pg_num_rows($res3)==0){
			$query = "INSERT INTO PLAYS(team_code,div_code) VALUES('$row[0]', '$row2[0]')";
			$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
			echo "Εγγραφή Ολοκληρώθηκε: ";
			echo "$query <br>";
		}
	}
}
echo "<br>";
fclose($filehandler);


$filehandler = fopen("./data/Αγώνες.csv", "r");			//Εισαγωγή από Αγωνες.csv για ενημέρωση συσχέτισης matches
fgets($filehandler);

while ($line = fgets($filehandler)){	
	$array = explode(",", $line);
	$array[22] =  pg_escape_string($array[22]);
	if($array[4]==""){
		$array[4] ='NULL';
	}
	if($array[5]==""){
		$array[5] ='NULL';
	}
	if($array[6]==""){
		$array[6] ='NULL';
	}
	if($array[7]==""){
		$array[7] ='NULL';
	}
	if($array[8]==""){
		$array[8] ='NULL';
	}
	if($array[9]==""){
		$array[9] ='NULL';
	}
	if($array[10]==""){
		$array[10] ='NULL';
	}
	if($array[11]==""){
		$array[11] ='NULL';
	}
	if($array[12]==""){
		$array[12] ='NULL';
	}
	if($array[13]==""){
		$array[13] ='NULL';
	}
	if($array[14]==""){
		$array[14] ='NULL';
	}
	if($array[15]==""){
		$array[15] ='NULL';
	}
	if($array[16]==""){
		$array[16] ='NULL';
	}
	if($array[17]==""){
		$array[17] ='NULL';
	}
	$res2 = pg_query($con, "select stadium_code from STADIUM where name='$array[22]'"); 
	$res = pg_query($con, "select div_code from CHAMPIONSHIP where name='$array[0]'");
	$res4 = pg_query($con, "select team_code from TEAMS where name='$array[2]'"); 
	$res5 = pg_query($con, "select team_code from TEAMS where name='$array[3]'");
	while ($row = pg_fetch_row($res2)) {
		$row2 = pg_fetch_row($res);
		$row4 = pg_fetch_row($res4);
		$row5 = pg_fetch_row($res5);
		$query = "INSERT INTO MATCHES (stadium_code,div_code,home_team,away_team,match_day,fthg,ftag,hf,af,hst,ast,hc,ac,hs,aws,hy,ay,hr,ar) VALUES('$row[0]', '$row2[0]', '$row4[0]', '$row5[0]', to_date('$array[1]','dd-mm-yy'), $array[4], $array[5], $array[6], $array[7], $array[8], $array[9], $array[10], $array[11], $array[12], $array[13], $array[14], $array[15], $array[16], $array[17])";
		$result=pg_query($con, $query)or die("Error in SQL query: " . pg_last_error());
		echo "Εγγραφή Ολοκληρώθηκε: ";
		echo "$query <br>";
	}	
}
echo "<br>";
fclose($filehandler);

pg_close($con);
?>

<div >

	<form action="index.html" method="post">
	<p align = "center">
 	<button style="height:30px; width:140px; font-size:75%">Home</button>
	</form>



</table>
</div>
</body>
</html>