<html>
<head>
	<title>SQL Queries </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="" bgcolor="#E1E6FA" text="Black" link="blue" vlink="red">

<?php 
$host = "localhost"; 
$user = "db1u19"; 
$pass = "mo6l1r9a"; 
$db = $user; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
	or die ("Could not connect to server\n"); 
		
if(isset($_POST['Submit1'])){
	echo "<b>Ερώτημα 1ο</b><br>";
	$H = pg_escape_string($_POST['H']);
	if($H){
		$query1 = "select firstname,lastname from players where age>$H order by firstname";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$playersrows = pg_numrows($res1);
	
		for($k=0; $k < $playersrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0]  $row1[1] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
}
if(isset($_POST['Submit2'])){
	echo "<b>Ερώτημα 2ο</b><br>";
	$S1 = pg_escape_string($_POST['S1']);
	$S2 = pg_escape_string($_POST['S2']);
	if($S1&&$S2){
		$query1 = "select DISTINCT stadium.name,stadium.capacity from stadium,plays,teams,based,championship where championship.name='Superleague' AND plays.div_code=championship.div_code AND teams.team_code=plays.team_code AND based.team_code=teams.team_code AND based.stadium_code=stadium.stadium_code AND capacity>$S1 AND capacity<$S2 order by capacity desc";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$stadiumrows = pg_numrows($res1);
		for($k=0; $k < $stadiumrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0] - $row1[1] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
}
if(isset($_POST['Submit3'])){
	echo "<b>Ερώτημα 3ο</b><br>";
	$Day1 = pg_escape_string($_POST['newDay1']);
	$Day2 = pg_escape_string($_POST['newDay2']);
	if($Day1&&$Day2){
		$query1 = "(select t1.name,t2.name from teams as t1,teams as t2,matches where t1.name='Πανιώνιος' AND t1.team_code=matches.home_team AND t2.team_code=matches.away_team AND matches.fthg<matches.ftag AND matches.match_day BETWEEN '$Day1' and '$Day2'
		UNION select t1.name,t2.name from teams as t1,teams as t2,matches where t1.name='Πανιώνιος' AND t1.team_code=matches.away_team AND t2.team_code=matches.home_team AND matches.fthg>matches.ftag AND matches.match_day BETWEEN '$Day1' and '$Day2')";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$stadiumrows = pg_numrows($res1);
		for($k=0; $k < $stadiumrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[1] <br>";
		}
	if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit4'])){
	echo "<b>Ερώτημα 4ο</b><br>";
	$query1 = "select teams.name, AVG(players.age) from teams,players,owns where teams.team_code=owns.teams_code AND players.players_code=owns.players_code group by teams.name";
	$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
	$teamrows = pg_numrows($res1);
	for($k=0; $k < $teamrows; $k++) {
		$row1=pg_fetch_row($res1);
		echo "$row1[0]  - $row1[1] <br>";
	}
}	
if(isset($_POST['Submit5'])){
	echo "<b>Ερώτημα 5ο</b><br>";
	$E = pg_escape_string($_POST['E']);
	if($E){
		$query1 = "select teams.name,teams.city from teams where teams.year_founded<$E order by teams.name";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$teamrows = pg_numrows($res1);
		for($k=0; $k < $teamrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0]  - $row1[1] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit6'])){
	echo "<b>Ερώτημα 6ο</b><br>";
	$Capacity = pg_escape_string($_POST['Capacity']);
	echo "$Capacity MO:";
	if($Capacity){
		$query1 = "select AVG(stadium.capacity) from stadium,plays,teams,based,championship where championship.name='$Capacity' AND plays.div_code=championship.div_code AND teams.team_code=plays.team_code AND based.team_code=teams.team_code AND based.stadium_code=stadium.stadium_code";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$stadiumrows = pg_numrows($res1);
		for($k=0; $k < $stadiumrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0]<br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit7'])){
	echo "<b>Ερώτημα 7ο</b><br>";
	$Goal = pg_escape_string($_POST['Goal']);
	if($Goal){
		$query1 = "select matches.match_day from matches where matches.fthg - matches.ftag > $Goal";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$matchrows = pg_numrows($res1);
		for($k=0; $k < $matchrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0]<br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit8'])){
	echo "<b>Ερώτημα 8ο</b><br>";
	$query1 = "select matches.match_day, teams.name, stadium.name, MAX(matches.ftag+matches.fthg) from matches,teams,based,stadium where matches.home_team=teams.team_code AND teams.team_code=based.team_code AND based.stadium_code=stadium.stadium_code AND matches.fthg IS NOT NULL AND matches.ftag IS NOT NULL group by matches.match_day, teams.name, stadium.name order by max desc LIMIT 1";
	$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
	$matchrows = pg_numrows($res1);
	for($k=0; $k < $matchrows; $k++) {
		$row1=pg_fetch_row($res1);
		echo "$row1[0] $row1[1] $row1[2]<br>";
	}
} 
if(isset($_POST['Submit9'])){
	echo "<b>Ερώτημα 9ο</b><br>";
	$B = pg_escape_string($_POST['B']);
	$query2 = "select * from players";
	$res2 = pg_query($con, $query2) or die("Cannot execute query: $query\n");
	$playersrows1 = pg_numrows($res2);
	if($B){
		$query1 = "select players from players where players.shooting+players.dribbling+players.pace > $B";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$playersrows = pg_numrows($res1);
		$per=($playersrows/$playersrows1)*100;
		echo "Per cent = $per%";
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
}
if(isset($_POST['Submit10'])){
	echo "<b>Ερώτημα 10ο</b><br>";
	$C = pg_escape_string($_POST['C']);
	if($C){
		$query1 = "select players.firstname, players.lastname, MAX(players.pace+players.dribbling+players.shooting) from players,owns,plays,teams,championship where championship.name='$C' AND players.players_code=owns.players_code AND owns.teams_code=teams.team_code AND plays.div_code=championship.div_code AND teams.team_code=plays.team_code group by players.firstname, players.lastname order by max desc LIMIT 1";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$playerrows = pg_numrows($res1);
		for($k=0; $k < $playerrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0] - $row1[1] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
}  
if(isset($_POST['Submit11'])){
	echo "<b>Ερώτημα 11ο</b><br>";
	$G = pg_escape_string($_POST['G']);
	if($G){
		$query1 = "select teams.name from teams,matches where teams.team_code=matches.home_team group by teams.name HAVING SUM(matches.ftag) < $G";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$teamrows = pg_numrows($res1);
		for($k=0; $k < $teamrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit12'])){
	echo "<b>Ερώτημα 12ο</b><br>";
	
	$query1 = "(select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t1.team_code=matches.home_team AND t2.team_code=matches.away_team AND t1.name='Π.Α.Ο.Κ.' AND matches.fthg<matches.ftag 
	UNION select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t2.team_code=matches.home_team AND t1.team_code=matches.away_team AND t1.name='Π.Α.Ο.Κ.' AND matches.fthg>matches.ftag)
	
	INTERSECT (select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t1.team_code=matches.home_team AND t2.team_code=matches.away_team AND t1.name='Ολυμπιακός' AND matches.fthg<matches.ftag
	UNION select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t2.team_code=matches.home_team AND t1.team_code=matches.away_team AND t1.name='Ολυμπιακός' AND matches.fthg>matches.ftag)
	
	INTERSECT (select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t1.team_code=matches.home_team AND t2.team_code=matches.away_team AND t1.name='Παναθηναϊκός' AND matches.fthg<matches.ftag 
	UNION select t2.name from teams as t1,teams as t2,matches,championship where championship.name='Superleague' AND championship.div_code=matches.div_code AND t2.team_code=matches.home_team AND t1.team_code=matches.away_team AND t1.name='Παναθηναϊκός' AND matches.fthg>matches.ftag)";
		
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$teamrows = pg_numrows($res1);
		for($k=0; $k < $teamrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0] $row1[1]<br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
} 
if(isset($_POST['Submit13'])){
	echo "<b>Ερώτημα 13ο</b><br>";
	$T = pg_escape_string($_POST['T']);
	if($T){
		$query1 = "select DISTINCT players.nation from players,owns,teams where players.players_code=owns.players_code AND owns.teams_code=teams.team_code AND teams.name='$T'";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$playerrows = pg_numrows($res1);
		for($k=0; $k < $playerrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "$row1[0] <br>";
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
} 
if(isset($_POST['Submit14'])){
	echo "<b>Ερώτημα 14ο</b><br>";
	$Day1 = pg_escape_string($_POST['Day1']);
	$Day2 = pg_escape_string($_POST['Day2']);
	$sum[]=0;
	$arr[0]='';
	$arr[1]=0;
	$brr[]='';
	if($Day1&&$Day2){
		
		$query1 = "select teams.name from teams,matches,plays,championship where teams.team_code=matches.home_team AND plays.div_code=championship.div_code AND plays.team_code=teams.team_code AND championship.name='Superleague' AND matches.match_day BETWEEN '$Day1' and '$Day2' group by teams.name,matches.fthg,matches.ftag HAVING matches.fthg>matches.ftag";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$stadiumrows = pg_numrows($res1);
		for($k=0; $k < $stadiumrows; $k++) {
			$row1=pg_fetch_row($res1);
			$arr[0]=$row1[0];
			$brr[$k]=$row1[0];
			for($i=0; $i< sizeof($brr); $i++){
				if(strcmp($brr[$i],$row1[0])==0){
					$sum[$k]=$sum[$k]+3;
				}
			}
		}
		$b=$k;
		$query2 = "select teams.name from teams,matches,plays,championship where teams.team_code=matches.away_team AND plays.div_code=championship.div_code AND plays.team_code=teams.team_code AND championship.name='Superleague' AND matches.match_day BETWEEN '$Day1' and '$Day2' group by teams.name,matches.fthg,matches.ftag HAVING matches.ftag>matches.fthg";
		$res2 = pg_query($con, $query2) or die("Cannot execute query: $query\n");
		$stadiumrows2 = pg_numrows($res2);
		for($k=0; $k < $stadiumrows2; $k++) {
			$row2=pg_fetch_row($res2);
			$arr[0]=$row2[0];
			$brr[$b]=$row2[0];
			for($i=0; $i< sizeof($brr); $i++){
				if(strcmp($brr[$i],$row2[0])==0){
					$sum[$b]=$sum[$b]+3;
				}
			}
		$b++;	
		}
		$query1 = "select teams.name from teams,matches,plays,championship where teams.team_code=matches.home_team AND plays.div_code=championship.div_code AND plays.team_code=teams.team_code AND championship.name='Superleague' AND matches.match_day BETWEEN '$Day1' and '$Day2' group by teams.name,matches.fthg,matches.ftag HAVING matches.fthg<matches.ftag";
		$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
		$stadiumrows = pg_numrows($res1);
		for($k=0; $k < $stadiumrows; $k++) {
			$row1=pg_fetch_row($res1);
			$arr[0]=$row1[0];
			$brr[$b]=$row1[0];
			for($i=0; $i< sizeof($brr); $i++){
				if(strcmp($brr[$i],$row1[0])==0){
					$sum[$b]=$sum[$b];
				}
			}
		}
		$query2 = "select teams.name from teams,matches,plays,championship where teams.team_code=matches.away_team AND plays.div_code=championship.div_code AND plays.team_code=teams.team_code AND championship.name='Superleague' AND matches.match_day BETWEEN '$Day1' and '$Day2' group by teams.name,matches.fthg,matches.ftag HAVING matches.ftag<matches.fthg";
		$res2 = pg_query($con, $query2) or die("Cannot execute query: $query\n");
		$stadiumrows2 = pg_numrows($res2);
		for($k=0; $k < $stadiumrows2; $k++) {
			$row2=pg_fetch_row($res2);
			$arr[0]=$row2[0];
			$brr[$b]=$row2[0];
			for($i=0; $i< sizeof($brr); $i++){
				if(strcmp($brr[$i],$row2[0])==0){
					$sum[$b]=$sum[$b];
				}
			}
		$b++;	
		}
		$c=$b;
		$brr2[]='';
		$brr3[]='';
		$b=0;
		$query3 = "select matches.home_team,matches.away_team from teams,matches,plays,championship where teams.team_code=matches.home_team AND plays.div_code=championship.div_code AND plays.team_code=teams.team_code AND championship.name='Superleague' AND matches.match_day BETWEEN '$Day1' and '$Day2' group by matches.home_team,matches.away_team,matches.fthg,matches.ftag HAVING matches.ftag=matches.fthg";
		$res3 = pg_query($con, $query3) or die("Cannot execute query: $query\n");
		$stadiumrows3 = pg_numrows($res3);
		for($k=0; $k < $stadiumrows3; $k++) {
			$row3=pg_fetch_row($res3);
			$query4 = "select teams.name from teams where teams.team_code=$row3[0]";
			$res4 = pg_query($con, $query4) or die("Cannot execute query: $query\n");
			$row4=pg_fetch_row($res4);
			$brr2[$k]=$row4[0];
			$query5 = "select teams.name from teams where teams.team_code=$row3[1]";
			$res5 = pg_query($con, $query5) or die("Cannot execute query: $query\n");
			$row5=pg_fetch_row($res5);
			$brr3[$k]=$row5[0];
		}
		$brr4[]='';
		for($k=0; $k < sizeof($brr2); $k++) {
			$brr4[$k]=$brr2[$k];
		}
		$b=0;
		for($i=$k; $i < sizeof($brr3)+$k; $i++) {
			$brr4[$i]=$brr3[$b];
			$b++;
		}
		$b=0;
		for($i=$c; $i < sizeof($brr4)+$c; $i++) {
			$brr[$i]=$brr4[$b];
			$b++;
		}
		for($k=0; $k < sizeof($brr4); $k++) {
			for($i=0; $i< sizeof($brr3); $i++){
				if(strcmp($brr3[$i],$brr4[$k])==0 OR strcmp($brr2[$i],$brr4[$k])==0){
					$sum2[$k]=$sum2[$k]+1;
				}
			}
		}
		array_multisort($sum2, SORT_DESC,$brr4);
		$result2 = array_unique($brr4);
		array_multisort($sum, SORT_DESC,$brr);
		$result = array_unique($brr);
		for($k=0; $k < sizeof($brr); $k++) {
			for($i=0; $i < sizeof($brr4); $i++) {
				if(strcmp($result2[$i],$brr[$k])==0){
					$sum[$k]=$sum2[$i]+$sum[$k];
				}	
			}
		}
		array_multisort($sum, SORT_DESC,$brr);
		$result = array_unique($brr);
		for($k=0; $k < sizeof($brr); $k++) {
			if($sum[$k]==NULL){$sum[$k]=0;}
			if($result[$k]!=''){
			echo "$result[$k] $sum[$k]<br>";	
			}
		}
		if($k==0){echo "Δεν υπάρχουν!<br>";}
	}else {
		echo "Τα απαιτούμενα πεδία ήταν κενά!<br>";
	}
}

if(isset($_POST['Submit15'])){
	echo "<b>Ερώτημα 15ο</b><br>";
	$query1 = "(select DISTINCT teams.name from teams,matches,championship,plays where championship.name='Premier League' AND championship.div_code=plays.div_code AND teams.team_code=plays.team_code AND teams.team_code=matches.home_team group by teams.name,matches.match_day,matches.fthg,matches.ftag,matches.hr,matches.ar HAVING matches.hr > matches.ar AND matches.fthg >= matches.ftag
	UNION select DISTINCT teams.name from teams,matches,championship,plays where championship.name='Premier League' AND championship.div_code=plays.div_code AND teams.team_code=plays.team_code AND teams.team_code=matches.away_team group by teams.name,matches.match_day,matches.fthg,matches.ftag,matches.hr,matches.ar HAVING matches.ar > matches.hr AND matches.fthg <= matches.ftag)";
	$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
	$teamrows = pg_numrows($res1);
	for($k=0; $k < $teamrows; $k++){
		$row1=pg_fetch_row($res1);
		echo "$row1[0]<br>";
	}
	if($k==0){echo "Δεν υπάρχουν!<br>";}
} 
if(isset($_POST['Submit16'])){
	echo "<b>Ερώτημα 16ο</b><br>";
	$query1 = "(select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg>matches.ftag INTERSECT select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg<matches.ftag) UNION (select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg>matches.ftag INTERSECT select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg=matches.ftag) UNION (select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg=matches.ftag INTERSECT select t1.name, t2.name from teams as t1,teams as t2,matches,championship where t1.team_code=matches.home_team AND t2.team_code=matches.away_team 
	AND matches.div_code=championship.div_code AND championship.name='Superleague' AND matches.fthg<matches.ftag)";
	$res1 = pg_query($con, $query1) or die("Cannot execute query: $query\n");
	$teamrows = pg_numrows($res1);
	for($k=0; $k < $teamrows; $k++) {
			$row1=pg_fetch_row($res1);
			echo "($row1[0], $row1[1])<br>";
	}		
} 

pg_close($con); 
?>

<div >
	
	<h1 align="center"><b>Επίλεξε Ερώτημα:</b></h1>
			
			<form align="center" action="sqlqueries.php" method="post" >
			
			<p align="center">1.Παίχτες που έχουν ηλικία μεγαλύτερη από: 
				<input type="number" name="H" min="1">	
				<input type="submit" alt="Submit" width="100" height="50" name="Submit1" value="Submit">
				
			<p align="center">2.Στάδια που έχουν χωρητικοτητα μεγαλύτερη από:
			<input type="number" name="S1">
			 και μικρότερη απο: 
			<input type="number" name="S2">ελληνικών ομάδων
			<input type="submit" alt="Submit" width="100" height="50" name="Submit2" value="Submit">
			
			<p align="center">3.Ομάδες που κέρδισαν των Πανιώνιο απο: 
				<input type="date" name="newDay1">
				μέχρι:
					<td><input type="date" name="newDay2" ></td></tr>(XXXX-MM-dd)
			<input type="submit" alt="Submit" width="100" height="50" name="Submit3" value="Submit">
			
			<p align="center">4.Μέσος όρος ηλικίας κάθε ομάδας
			<input type="submit" alt="Submit" width="100" height="50" name="Submit4" value="Submit">
						
			<p align="center">5.Ομάδες που ιδρύθηκαν πριν το έτος:
			<input type="number" name="E" min="0">
			<input type="submit" alt="Submit" width="100" height="50" name="Submit5" value="Submit">
			
			<p align="center">6.Μέση χωρητικότητα γηπέδων όπου οι ομάδες τους αγωνίζονται στο πρωτάθλημα:
			<input type="text" name="Capacity" maxlength="60" >
			<input type="submit" alt="Submit" width="100" height="50" name="Submit6" value="Submit">
			
			<p align="center">7.Βρείτε όλες τις ημρομηνίες των αγώνων που η διαφορά τερμάτων υπέρ του 
			γηπεδούχου ήταν μεγαλύτερη από: 
			<input type="number" name="Goal">γκολ
			<input type="submit" alt="Submit" width="100" height="50" name="Submit7" value="Submit">
			
			<p align="center">8.Βρείτε τον γηπεδούχο, το όνομα του γηπέδου και την ημερομήνια του αγώνα 
								που μπήκα τα περισσότερα γκολ συνολικά
			<input type="submit" alt="Submit" width="100" height="50" name="Submit8" value="Submit">
 	
			<p align="center">9.Βρείτε το ποσοστό των παιχτών που οι βαθμοί ικανότητας τους αθροιστικά σε 
			ταχύτητα, σουτ και τρίπλα είναι μεγαλύτερη από:
			<input type="number" name="B" min="0">
			<input type="submit" alt="Submit" width="100" height="50" name="Submit9" value="Submit">
			
			<p align="center">10.Βρείτε τον καλύτερο παίχτη που αγωνίζεται σε θέση επιθετικού στο πρωτάθλημα:
			<input type="text" name="C" maxlength="60">.
			<input type="submit" alt="Submit" width="100" height="50" name="Submit10" value="Submit">
			
			<p align="center">11.Βρείτε όλες τις ομάδες που δέχτηκαν λιγότερα από: 
			<input type="number" name="G" >γκολ στην έδρα τους
			<input type="submit" alt="Submit" width="100" height="50" name="Submit11" value="Submit">

			<p align="center">12. Για κάθε διεξαγωγή του ελληνικού πρωταθλήματος βρείτε τις ομάδες
								  που έχουν κερδίσει Παναθηναϊκο, Ολυμπιακό και Π.Α.Ο.Κ.
			<input type="submit" alt="Submit" width="100" height="50" name="Submit12" value="Submit">

			<p align="center">13.Βρείτε όλες τις εθνικότητες που αγωνίστηκαν στην ομάδα: 
			<input type="text" name="T" >					
			<input type="submit" alt="Submit" width="100" height="50" name="Submit13" value="Submit">

			<p align="center">14.Βρείτε τη βαθμολογική κατάταξη του ελληνικού πρωταθλήματος για το διάστημα από:
			<input type="date" name="Day1">
				μέχρι:
					<td><input type="date" name="Day2" ></td></tr>(XXXX-MM-dd)
			<input type="submit" alt="Submit" width="100" height="50" name="Submit14" value="Submit">

			<p align="center">15. Βρείτε όλες τις αγγλικές ομάδες που ενώ τελείωσαν το παιχνίδι 
								  με λιγότερους παίχτες από την αντίπαλη ομάδα, κατάφεραν τελικά
								  να μην ηττηθούν
			<input type="submit" alt="Submit" width="100" height="50" name="Submit15" value="Submit">
											
			<p align="center">16. Για το ελλήνικο πρωτάθλημα: Βρείτε τα ζευγάρια των ομάδων που στους 
								  μεταξύ τους αγώνες είχαν διαφορετικό αποτέλεσμα σε διαφορετίκες 
								  διεξαγωγές του πρωταθλήματος
			<input type="submit" alt="Submit" width="100" height="50" name="Submit16" value="Submit">	

				
			</form>
			
			<form action="index.html" method="post">
			<input type="image" src="minicons-28-512.png" alt="Submit" width="48" height="48">
			</form>


</div>

</body>


</html>

