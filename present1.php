<html>
<head>
	<title>Παρουσίαση πρωταθλημάτων, ομάδων και παιχτών. </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style> type="text/css">
    tab1 { padding-left: 4em; }
    tab2 { padding-left: 7em; }
    tab3 { padding-left: 10em; }
	</style>
</head>

<!-- http://zetcode.com/db/postgresqlphp/read/ -->

<body  background="" bgcolor="lightblue" text="Black" link="Blue" vlink="Red">
	<h1 align="center">Παρουσίαση πρωταθλημάτων, ομάδων και παιχτών. </h1>	
	
<?php 
$host = "localhost"; 
$user = "db1u19"; 
$pass = "mo6l1r9a"; 
$db = $user; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
	or die ("Could not connect to server\n"); 

$query2= "select teams.name, championship.name, players.firstname, players.lastname  from teams, plays, players, owns, championship where plays.div_code=championship.div_code AND owns.teams_code=teams.team_code AND owns.players_code= players.players_code AND teams.team_code=plays.team_code order by championship.name, teams.name, players.firstname ";
$rs = pg_query($query2);
$ch="";
$team="";
$divcount1=1;
$divcount2=1;
$divcount4=0;
$divcount5=0;
while ($row = pg_fetch_row($rs)){
		
		if ($ch != $row[1]){
			echo "$row[1] $divcount1<br>";
			$ch = $row[1];
			$divcount1++;
			$divcount4++;
			$divcount2=1;
			$divcount5=0;
		}
		if($team != $row[0]){
			echo "&nbsp &nbsp &nbsp $row[0] $divcount4.$divcount2<br>";	
			$team = $row[0];
			$divcount2++;
			$divcount5++;
			$divcount3=1;
		}
		echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp $row[2] - $row[3] $divcount4.$divcount5.$divcount3<br>";
		$divcount3++;
}
pg_close($con); 
?>

<div >

	
	<form action="index.html" method="post">
	<p align = "center">
 	<button style="height:30px; width:140px; font-size:75%">Home</button>
	</form>
	<form action="presentation.php" method="post">
 	<input type="image" src="minicons-28-512.png" alt="Submit" width="48" height="48">
	</form>


</div>
</body>
</html>