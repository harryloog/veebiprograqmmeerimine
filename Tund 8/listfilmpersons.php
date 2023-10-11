<?php 

  require("use_session.php");
  require("../../../config.php");
  require("fnc_filmrelations.php");
  

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
  
  $sortby = 0;
  $sortorder = 0;
  
  require("header.php");
?>
<!DOCTYPE html>
<html lang="et">
<body>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
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
  <?php 
  if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
	  if($_GET["sortorder"] >= 1 and $_GET["sortby"] <= 4) {
		$sortby = $_GET["sortby"];
		$sortorder = $_GET["sortorder"];
	  }
  }echo readpersonsinfilm($sortby, $sortorder);?>
</body>
</html>