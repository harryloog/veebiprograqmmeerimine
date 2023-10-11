<?php
  session_start();
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	  //jõugu sisselogimise lehele
	  header("Location: page.php");
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	   header("Location: page.php");
	   exit();
  }
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  require("fnc_filmrelations.php");
  
  $genrenotice = "";
  $studionotice = "";
  $personnotice = "";
  $positionnotice = "";
  $quotenotice = "";
  $selectedfilm = "";
  $selectedgenre = "";
  $selectedstudio = "";
  $selectedperson = "";
  $selectedposition = "";
  $selectedquote = "";
  
  if(isset($_POST["filmstudiorelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$studionotice = " Vali film!";
	}
	if(!empty($_POST["studioinput"])){
		$selectedstudio = intval($_POST["studioinput"]);
	} else {
		$studionotice .= " Vali stuudio!";
	}
	if(!empty($selectedfilm) and !empty($selectedstudio)){
		$studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
	}
  }	
  if(isset($_POST["filmgenrerelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$genrenotice = " Vali film!";
	}
	if(!empty($_POST["filmgenreinput"])){
		$selectedgenre = intval($_POST["filmgenreinput"]);
	} else {
		$genrenotice .= " Vali žanr!";
	}
	if(!empty($selectedfilm) and !empty($selectedgenre)){
		$genrenotice = storenewgenrerelation($selectedfilm, $selectedgenre);
	}
  }
  if(isset($_POST["filmpersonrelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$personnotice = " Vali film!";
	}
	if(!empty($_POST["filmpersoninput"])){
		$selectedperson = intval($_POST["filmpersoninput"]);
	} else {
		$personnotice .= " Vali isik!";
	}
	if(!empty($_POST["filmpositioninput"])){
		$selectedposition = intval($_POST["positioninput"]);
	}else {
		$personnotice .= " Vali positsioon!";
	}
	if(!empty($selectedfilm) and !empty($selectedperson) and !empty($selectedposition)){
		$personnotice = storenewpersonrelation($selectedfilm, $selectedperson, $selectedposition);
	}
  }
  if(isset($_POST["filmquoterelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$quotenotice = " Vali film!";
	}
	if(!empty($_POST["filmquoteinput"])){
		$selectedquote	= intval($_POST["filmquoteinput"]);
	} else {
		$quotenotice .= " Vali tsitaat!";
	}
	if(!empty($selectedfilm) and !empty($selectedquote)){
		$quotenotice = storenewquoterelation($selectedfilm, $selectedquote);
	}
  }
  
  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmgenreselecthtml = readgenretoselect($selectedgenre);
  $filmstudioselecthtml = readstudiotoselect($selectedstudio);
  $filmpersonselecthtml = readpersontoselect($selectedperson);
  $filmpositionselecthtml = readpositiontoselect($selectedposition);
  $filmquoteselecthtml = readquotetoselect($selectedquote);


  //$username = "Andrus Rinde";

  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    
  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  
  <h2>Lisa stuudio</h2>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmstudioselecthtml;
	?>
	
	<input type="submit" name="filmstudiorelationsubmit" value="Salvesta seos stuudioga"><span><?php echo $studionotice; ?></span>
  </form>
  
  <h2>Lisa žanr</h2>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>
	
	<input type="submit" name="filmgenrerelationsubmit" value="Salvesta filmiinfo"><span><?php echo $genrenotice; ?></span>
  </form>
  
  <h2>Lisa isik</h2>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmpersonselecthtml;
		echo $filmpositionselecthtml;
	?>
	
	<input type="submit" name="filmpersonrelationsubmit" value="Salvesta filmiinfo"><span><?php echo $personnotice; ?></span>
  </form>
  
  <h2>Lisa tsitaat</h2>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmpersonselecthtml;
		echo $filmquoteselecthtml;
	?>
	
	<input type="submit" name="filmquoterelationsubmit" value="Salvesta filmiinfo"><span><?php echo $quotenotice; ?></span>
  </form>
  
</body>
</html>
