<?php
  //käivitan sessiooni
  session_start();
  //var_dump($_POST);
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  $database = "if20_harry_lo_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  $emailerror="";
  $passworderror=""; 
  $email ="";
  
	if(isset($_POST["usersubmit"]) and !empty($_POST["usersubmit"])){
		if(empty($_POST["emailinput"])){
		  $emailerror .="Kasutajanimi on sisestamata! ";
		}
		if(empty($_POST["passwordinput"])){
		  $passworderror .="Salasõna on sisestamata! ";
		}
		else{
			if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror .="Salasõna on liiga lühike!";
			}
			else{
				if(isset($_POST["emailinput"]) and !empty($_POST["emailinput"])){
				  $email  = test_input($_POST["emailinput"]);
				}
				
			}
		}
		if(empty($emailerror) and empty($passworderror)){
			$result = signin($email, $_POST["passwordinput"]);
			
			if($result == "ok"){
				$notice="Kõik korras, aksutaja loodud!";
				$email=null;
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
<body>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow-1] .", " .$datenow .". " .$monthnameset[$monthnow-1] ." " .$yearnow .", kell " .$timenow; ?>.</p>
  <ul>
  <li><a href="login.php">Registreeri kasutajaks<a/></li>
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
<p>Logi sisse!<p>
<label>E-mail</label>
<br>
<input type="email" name="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
<br><br>
<label>Salasõna</label>
<br>
<br>
<input type="password" name="passwordinput"><span><?php echo $passworderror; ?></span>
<br><br>
<input type="submit" name="usersubmit" value="Logi sisse">
</form>
<br>
<br>

<?php if(isset($notice)){echo $notice;}?>
</body>
</html>