<?php 

  require("use_session.php");
  require("../../../config.php");
  require("fnc_films.php");
  


  $inputerror = "";
  //kui klikiti submit, siis ...
  if(isset($_POST["filmsubmit"])){
	if(empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
	  $inputerror .="Osa infot on sisestamata! ";
	}
	if($_POST["yearinput"] > date("Y") or $_POST["yearinput"] < 1895){
	  $inputerror .= "Ebareaalne valmimisaasta!";
	}
	if($inputerror==""){
		savefilm($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
	}
  }
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

  <hr>
  <h2>Lisa uus film!</h2>
  <br>
  <form method ="POST">
    <label for="titleinput">Filmi pealkiri</label>
	<input type="text" name="titleinput" id="titleinput" placeholder="Pealkiri">
	<br>
	<label for="yearinput">Filmi valmimisaasta</label>
	<input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y"); ?>">
	<br>
	<label for="durationinput">Filmi pikkus</label>
	<input type="number" name="durationinput" id="durationinput" value="80">
	<br>
	<label for="genreinput">Filmi žanr</label>
	<input type="text" name="genreinput" id="genreinput" placeholder="Žanr">
	<br><label for="studioinput">Filmistuudio</label>
	<input type="text" name="studioinput" id="studioinput" placeholder="Stuudio">
	<br><label for="directorinput">Filmi lavastaja</label>
	<input type="text" name="directorinput" id="directorinput" placeholder="Tanel Toom">
	<br>
	<input type="submit" name="filmsubmit" value="Salvesta filmi info">
	<br>
  </form>
  <br><h2>Lisa uus isik</h2><br>
  <form method ="POST">
    <label for="firstnameinput">Nimi</label>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi">
	<br>
	<label for="lastnameinput">Perenimi</label>
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perenimi">
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
	<h2>Lisa žanr!</h2>
	<br>
	<label for="genrenameinput">Žanri nimi</label>
	<input type="text " name="durationinput" id="durationinput" value="80">
	<br>
	<label for="genreinput">Filmi žanr</label>
	<input type="text" name="genreinput" id="genreinput" placeholder="Žanr">
	<br><label for="studioinput">Filmistuudio</label>
	<input type="text" name="studioinput" id="studioinput" placeholder="Stuudio">
	<br><label for="directorinput">Filmi lavastaja</label>
	<input type="text" name="directorinput" id="directorinput" placeholder="Tanel Toom">
	<br>
	<input type="submit" name="filmsubmit" value="Salvesta filmi info">
	<br>
  </form>
  <p><?php echo $inputerror; ?></p>
</body>
</html>