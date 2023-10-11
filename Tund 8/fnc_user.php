<?php
	$database = "if20_harry_lo_1";
	
	function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
		$notice=null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt=$conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?,?,?,?,?,?)");
		echo $conn->error;
		
		//krüpteerime salasõna
		$options = ["cost" =>12, "salt"=> substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
		
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	function signin($email, $password){
		$notice=null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt=$conn->prepare("SELECT password FROM vpusers WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($password_from_db);
		
		if($stmt->execute()){
			//kui tehniliselt korras
			if($stmt->fetch()){
				//kasutaja leiti
				if(password_verify($password, $password_from_db)){
					//parool õige
					$stmt->close();
					
					//loen sisseloginud kasutaaj infot
					$stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
					echo $conn->error;
					$stmt->bind_param("s", $email);
					$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
					$stmt->execute();
					$stmt->fetch();
					//salvestame sessioonimuutujad
					$_SESSION["userid"] = $idfromdb;
					$_SESSION["userfirstname"] = $firstnamefromdb;
					$_SESSION["userlastname"] = $lastnamefromdb;
					
					//värvid tuleb lugeda profiilist, kui on
					$stmt->close();
					$stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");
					echo $conn->error;
					$stmt->bind_param("i", $idfromdb);
					$stmt->bind_result($userbgcolor, $usertxtcolor);
					$stmt->execute();
					$stmt->fetch();
					
					$_SESSION["userbgcolor"] = $userbgcolor;
					$_SESSION["usertxtcolor"] = $usertxtcolor;
					
					$stmt->close();
					$conn->close();
					header("Location: home.php");
					exit();
				} else {
					$notice = "Vale salasõna!";
				}
			} else {
				$notice="Sellist kasutajat (" .$email .") ei leitud!";
			}
		} else{
		
			//tehniline viga
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	function storeuserprofile($description, $bgcolor, $txtcolor){
		$notice=null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt=$conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($profileidfromdb);
		$stmt->execute();
		//kui tehniliselt korras
		if($stmt->fetch()){
			$stmt->close();
			$stmt=$conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("isss", $_POST["descriptioninput"], $_POST["bgcolorinput"], $_POST["txtcolorinput"], $_SESSION["userid"]);
			$stmt->execute();
		} else {
			$stmt->close();
			$stmt=$conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_POST["descriptioninput"], $_POST["bgcolorinput"], $_POST["txtcolorinput"], $_SESSION["userid"]);
			$stmt->execute();
		}
		$stmt->close();
		$conn->close();
		return $notice;	
	}
	function readuserdescription(){
	  //kui profiil on olemas, loeb kasutaja lühitutvustuse
	  $notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//vaatame, kas on profiil olemas
		$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($descriptionfromdb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $descriptionfromdb;
		}
		$stmt->close();
		$conn->close();
		return $notice;
  }
