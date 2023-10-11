<?php
  require("use_session.php");

  
  //kas on sisse loginud

  //var_dump($_POST);
  require("../../../config.php");
  $database = "if20_harry_lo_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideasubmit"])){
	  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //vbalmistan ettte SQL käsu
	  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	  echo $conn->error;
	  //seome käsuga pärisandmed
	  //i -integer, d - decimal, s - string
	  $stmt->bind_param("s", $_POST["ideainput"]);
	  $stmt->execute();
	  $stmt->close();
	  $conn->close();
  }
  
  //loen lehele kõik olemasolevad mõtted
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn ->prepare("SELECT idea FROM myideas");
  echo $conn->error;
  //seome tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  $ideahtml = "";
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
  
  
 
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
	$picfiletypes = ["image/jpeg", "image/png"];
	//loeme piltide kataloogi sisu ja näitame püilte
	$allfiles = array_slice(scandir("../vp-pics/"), 2);
	//$allfiles = scandir("../vp-pics/");
	//var_dump($allfiles);
	//$pic_files = array_slice($allfiles, 2);
	$pic_files = [];
	//var_dump($pic_files);
	foreach($allfiles as $thing){
	  $fileinfo = getImagesize("../vp-pics/" .$thing);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true){
		  array_push($pic_files, $thing);
	  }
	}
	$pic_count=count($pic_files);
	//paneme kõik pildid ekraanile
	$img_html = "";
	$img_html = '<img src="../vp-pics/' .$pic_files[mt_rand(0,$pic_count-1)] .'" alt="Tallinna Ülikool"/>';
//	for($i = 0; $i < $pic_count; $i ++){
//		$img_html .= '<img src="../vp-pics/' .$pic_files[$i] .'" ';
//		$img_html .= 'alt="Tallinna Ülikool"/>';
//	}//i=i+1 i=i++ i+=2
	
  require("header.php");
?>
<!DOCTYPE html>
<html lang="et">
<body>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli<a/> Digitehnoloogiate instituudis.<p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow-1] .", " .$datenow .". " .$monthnameset[$monthnow-1] ." " .$yearnow .", kell " .$timenow; ?>.</p>
  <p><a href="?logout=1">Logi välja</a>!</p>
  <ul>
  <li><a href="form.php">Vajuta siia et sisestada oma mõte!</a></li>
  <li><a href="userprofile.php">muuda kasutajaprofiili</a></li>
<li><a href="list.php">Vajuta siia et vaadata oma mõtteid!</a></li>
<li><a href="listfilms.php">Vajuta siia et vaadata filme!</a></li>
<li><a href="addfilms.php">Filmiinfo lisamine</a></li>
<li><a href="addfilmrelationship.php">Lisa stuudiole film!<a/></li>
<li><a href="listfilmpersons.php">Vaata filmide osanikke!<a/></li>
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
<!--  
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner"/>
-->
<hr>
<p><?php echo $img_html;?></p>
<hr>
</body>
</html>