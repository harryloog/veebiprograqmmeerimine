<?php
  $database = "if20_harry_lo_1";
  //var_dump($GLOBALS);
  //funktsioon, mis loeb kõikide filmide info.
  function readfilms(){
	      $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		  //$stmt = $conn ->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
		  $stmt = $conn ->prepare("SELECT * FROM film");
		  echo $conn->error;
		  //seome tulemuse muutujaga
		  $stmt->bind_result($titlefromdb,$yearfrom,$durationfromdb,$genrefromdb,$studiofromdb,$directorfromdb);
		  $stmt->execute();
		  $filmhtml = "\t<ol>\n";
		  while($stmt->fetch()){
			  $filmhtml .= "\t\t<li>" .$titlefromdb ."</li>\n";
			  $filmhtml .= "\t\t\t<ul>\n";
			  $filmhtml .= "\t\t\t\t<li>Valmimisaasta: " .$yearfrom ."</li>\n";
			  $filmhtml .= "\t\t\t\t<li>Kestus minutites: " .$durationfromdb ." minutit</li>\n";
			  $filmhtml .= "\t\t\t\t<li>Žanr: " .$genrefromdb ."</li>\n";
			  $filmhtml .= "\t\t\t\t<li>Stuudio: " .$studiofromdb ."</li>\n";
			  $filmhtml .= "\t\t\t\t<li>Lavastaja: " .$directorfromdb ."</li>\n";
			  $filmhtml .= "\t\t\t</ul>\n";
		  }
		  $filmhtml .= "\t</ol>\n";
		  $stmt->close();
		  $conn->close();
		  return $filmhtml;
  }//readfilms lõppeb
  function savefilm($titleinput, $yearinput, $durationinput, $descriptioninput){
		  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		  $stmt = $conn ->prepare("SELECT movie_id FROM movie WHERE title, production_year, duration, description = ?,?,?,?");
		  $stmt->bind_param("siis", $titleinput, $yearinput, $durationinput, $descriptioninput);
		  
		  $stmt->execute();
		  if($stmt->fetch()){
			 $notice = "Selline kirje on juba olemas"
		  } else {
			  $stmt = $conn->prepare("INSERT INTO movie (title, production_year, duration, description) VALUES (?,?,?,?,?,?)");
		  echo $conn->error;
		  $stmt->bind_param("siisss", $titleinput, $yearinput, $durationinput, $genreinput, $studioinput, $directorinput);
		  $stmt->execute();
		  $stmt->close();
		  $conn->close();
  }//savefilm lõppeb