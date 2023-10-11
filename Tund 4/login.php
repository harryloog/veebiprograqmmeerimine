<?php
  //var_dump($_POST);
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  $database = "if20_harry_lo_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  $error1="";
  $error2="";
  $error3="";
  $error4="";
  $error5="";
  $error6="";
  $birthdayerror=null;
  $birthmontherror=null;
  $birthyearerror=null;
  $birthdateerror=null;

  $firstname ="";
  $lastname ="";
  $gender ="";
  $email ="";
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $birthdate = null;
  
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
	if(empty($_POST["birthdayinput"])){
	  $birthdayerror .="Sünnipäev on sisestamata! ";
	}
	if(empty($_POST["birthmonthinput"])){
	  $birthmontherror .="Sünnikuu on sisestamata! ";
	}
	if(empty($_POST["birthyearinput"])){
	  $birthyearerror .="Sünniaasta on sisestamata! ";
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
	  	if(isset($_POST["firstnameinput"]) and !empty($_POST["firstnameinput"])){
	  	  $firstname  = test_input($_POST["firstnameinput"]);
	  	}
	  	if(isset($_POST["lastnameinput"]) and !empty($_POST["lastnameinput"])){
	  	  $lastname  = test_input($_POST["lastnameinput"]);
	  	}
	  	if(isset($_POST["genderinput"]) and !empty($_POST["genderinput"])){
	  	  $gender  = intval($_POST["genderinput"]);
	  	}
	  	if(isset($_POST["birthmonthinput"]) and !empty($_POST["birthmonthinput"])){
	  	  $birthmonth  = intval($_POST["birthmonthinput"]);
	  	}
	  	if(isset($_POST["birthdayinput"]) and !empty($_POST["birthdayinput"])){
	  	  $birthday  = intval($_POST["birthdayinput"]);
	  	}
	  	if(isset($_POST["birthyearinput"]) and !empty($_POST["birthyearinput"])){
	  	  $birthyear = intval($_POST["birthyearinput"]);
		}
		if(isset($birthday) and isset($birthmonth) and isset($birthyear) and!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
		  if(checkdate($birthmonth, $birthday, $birthyear)){
			  $tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
			  $birthdate = $tempdate->format("Y-m-d");
			  echo $birthdate;
		  } else {
			  $birthdateerror = "Kuupäev ei ole reaalne!";
		  }
		}
		if(isset($_POST["emailinput"]) and !empty($_POST["emailinput"])){
		  $email  = test_input($_POST["emailinput"]);
		}
      }
	}
  	if(isset($_POST["usersubmit"]) and empty($error1) and empty($error2) and empty($error3) and empty($birthdayerror) and empty($birthmontherror) and empty ($birthyearerror) and empty($birthdateerror) and empty($error4) and empty($error5) and empty($error6)){
	  $result = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);	
	  if($result == "ok"){
		$notice="Kõik korras, aksutaja loodud!";
		$firstname=null;
		$lastname=null;
		$email=null;
		$gender=null;
		$birthdate=null;
		$birthday=null;
		$birthmonth=null;
		$birthyear=null;
	  } else {
		  $notice = "Tekkis tehniline tõrge: " .$result;
	  }	//$notice = "Kõik korras!";
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
	<hr>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<p>Registreeri kasutajaks!<p>
<p>Sisesta info<p>
<label>Eesnimi</label>
<br>
<br>
<input type="text" name="firstnameinput" value="<?php echo $firstname; ?>" placeholder = "Sisesta oma eesnimi!"><span><?php echo $error1; ?></span>
<br>
<br>
<label>Perekonnanimi</label>
<br>
<br>
<input type="text" name="lastnameinput" value="<?php echo $lastname; ?>" placeholder = "Sisesta oma perekonnanimi!"><span><?php echo $error2; ?></span>
<br>
<br>
<label>Sugu</label>
<br>
<br>
<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>><label for="gendermale">Mees</label>
<br>
<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>><label for="genderfemale">Naine</label><span><?php echo $error3; ?></span>
<br>
<br>
<label for="birthdayinput">Sünnipäev: </label>
  <?php
	echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
	echo '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		echo '<option value="' .$i .'"';
		if ($i == $birthday){
			echo " selected ";
		}
		echo ">" .$i ."</option> \n";
	
}
	echo "</select> \n";
  ?>
<label for="birthmonthinput">Sünnikuu: </label>
<?php
echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
echo '<option value="" selected disabled>kuu</option>' ."\n";
for ($i = 1; $i < 13; $i ++){
	echo '<option value="' .$i .'"';
	if ($i == $birthmonth){
		echo " selected ";
	}
	echo ">" .$monthnameset[$i - 1] ."</option> \n";
}
echo "</select> \n";
?>
<label for="birthyearinput">Sünniaasta: </label>
<?php
echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
echo '<option value="" selected disabled>aasta</option>' ."\n";
for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
	echo '<option value="' .$i .'"';
	if ($i == $birthyear){
		echo " selected ";
	}
	echo ">" .$i ."</option> \n";
}
echo "</select> \n";
?>
<br>
<br>
<span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span><label>E-mail</label>
<br>
<br>
<input type="email" name="emailinput" value="<?php echo $email; ?>"><span><?php echo $error4; ?></span>
<br>
<br>
<label>Salasõna</label>
<br>
<br>
<input type="password" name="passwordinput"><span><?php echo $error5; ?></span>
<br>
<br>
<label>Korda salasõna</label>
<br>
<br>
<input type="password" name="passwordseconaryinput"><span><?php echo $error6; ?></span>
<br>
<br>
<input type="submit" name="usersubmit" value="Registreeri!">
</form>
<br>
<br>
<?php if(isset($notice)){echo $notice;}?>
</body>
</html>