<?php
  //var_dump($_POST);
  require("../../../config.php");
  require("fnc_common.php");
  $database = "if20_harry_lo_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  $error1="";
  $error2="";
  $error3="";
  $error4="";
  $error5="";
  $error6="";

  if(isset($_POST["usersubmit"]) and !empty($_POST["usersubmit"])){
	if(empty($_POST["firstnameinput"])){
	  $error1 .="Eesnimi on sisestamata! ";
	}
	if(empty($_POST["lastnameinput"])){
	  $error2 .="Perekonnanimi on sisestamata! ";
	}
	if(empty($_POST["genderinput"])){
	  $error3 .="Sugu on sisestamata! ";
	}
	if(empty($_POST["emailinput"])){
	  $error4 .="Kasutajanimi on sisestamata! ";
	}
	if(empty($_POST["passwordinput"])){
	  $error5 .="Salasõna on sisestamata! ";
	}
	else{
		if(empty($_POST["passwordseconaryinput"])){
		  $error6 .="Salasõna kordus on sisestamata! ";
		}
		if(strlen($_POST["passwordinput"]) < 8){
		  $error5 .="Salasõna on liiga lühike!";
		}
		if($_POST["passwordinput"] != $_POST["passwordseconaryinput"]){
		  $error6 .="Salasõnad on erinevad!";
		}
		else{
			if(isset($_POST["firstnameinput"])){
			  $firstname  = test_input($_POST["firstnameinput"]);
			}
			if(isset($_POST["lastnameinput"])){
			  $lastname  = test_input($_POST["lastnameinput"]);
			}
			if(isset($_POST["genderinput"])){
			  $gender  = intval($_POST["genderinput"]);
			}
			if(isset($_POST["emailinput"])){
			  $email  = test_input($_POST["emailinput"]);
			}
		}
	}
	  #$conn = new ...
	#  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //vbalmistan ettte SQL käsu
	#  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	#  echo $conn->error;
	  //seome käsuga pärisandmed
	  //i -integer, d - decimal, s - string
	#  $stmt->bind_param("s", $_POST["ideainput"]);
	#  $stmt->execute();
	#  $stmt->close();
	#  $conn->close();
  }
  $firstname ="";
  $lastname ="";
  $gender ="";
  $email ="";
 
  $username = "Harry Loog";
  $yearnow = date("Y");
  $datenow = date("d");
  $timenow = date("H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
#  var_dump($weekdaynameset);
#  echo $weekdaynameset;
	$weekdaynow = date("N");
	$monthnow = date("m");
#	echo $weekdaynow;
  if($hournow <=6 and $hournow>0){
	  $partofday = "öö";
  }
  if($hournow <12 and $hournow >6){
	  $partofday = "hommik";
  }
  if($hournow ==12){
	  $partofday = "keskpäev";
  }
  if($hournow >12 and $hournow<=16){
	  $partofday = "pärastlõuna";
  }
  if($hournow >16 and $hournow<24){
	  $partofday = "õhtu";
  }

  //vaatame semestri kulgemist
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a"); //%a - päevade arv
  $today = new DateTime("now");
  $dayselapsed = $semesterstart->diff($today);
  $dayselapseddays = $dayselapsed->format("%r%a");
  if($dayselapseddays >= 0 and $dayselapseddays <= $semesterduration){
	  $dayselapsedpercentage = round($dayselapseddays/$semesterdurationdays*100 , 2);
}

  require("header.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title><?php echo $username; ?> programmeerib veebi</title>
</head>
<body>
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogiate instituudis.<p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow-1] .", " .$datenow .". " .$monthnameset[$monthnow-1] ." " .$yearnow .", kell " .$timenow; ?>.</p>
  <ul>
  <li><a href="home.php">Avaleht<a/></li>
  </ul>
  <p><?php echo "Praegu on " .$partofday ."."; ?></p>
  <?php
		if($dayselapseddays > 0 and $dayselapseddays < $semesterduration){
			echo "Semester on käimas.\nOn semestri " .$dayselapseddays .". päev.\n" ."Semestrist on läbitud " .$dayselapsedpercentage ."%";
		}
		if($dayselapseddays <0){
			echo "Semester pole veel alanud!";
		}
		if($dayselapseddays > $semesterduration){
			echo "Semester on juba läbi.";
		}
		if($dayselapseddays == 0){
			echo "Semester algab täna\nSemestrist on läbitud " .$dayselapsedpercentage ."%";
		}
		if($dayselapseddays == $semesterdurationdays){
			echo "Semester lõpeb täna\nSemestrist on läbitud " .$dayselapsedpercentage ."%";
		}
	?>
	<hr>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<p>Registreeri kasutajaks!<p>
<p>Sisesta info<p>
<label>Eesnimi</label>
<br>
<br>
<input type="text" name="firstnameinput" value="<?php echo $firstname; ?>" placeholder = "Sisesta oma eesnimi!"><span><?php echo $error1; ?></span>
<br><br>
<label>Perekonnanimi</label>
<br>
<br>
<input type="text" name="lastnameinput" value="<?php echo $lastname; ?>" placeholder = "Sisesta oma perekonnanimi!"><span><?php echo $error2; ?></span>
<br><br>
<label>Sugu</label>
<br>
<br>
<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>><label for="gendermale">Mees</label>
<br>
<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>><label for="genderfemale">Naine</label><span><?php echo $error3; ?></span>
<br><br>
<label>E-mail</label>
<br>
<br>
<input type="email" name="emailinput" value="<?php echo $email; ?>"><span><?php echo $error4; ?></span>
<br><br>
<label>Salasõna</label>
<br>
<br>
<input type="password" name="passwordinput"><span><?php echo $error5; ?></span>
<br><br>
<label>Korda salasõna</label>
<br>
<br>
<input type="password" name="passwordseconaryinput"><span><?php echo $error6; ?></span>
<br>
<br>
<input type="submit" name="usersubmit" value="Registreeri!">
</form>

</body>
</html>