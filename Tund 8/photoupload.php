<?php 

  require("use_session.php");
  require("../../../config.php");
  $notice = null;
  $inputerror = "";
  $filetype = null;
  $filesizelimit= 1048576;
  $fotouploaddir_orig = "../photoupload_orig/";
  $fotouploaddir_normal = "../photoupload_normal/";
  $thumb = "../photoupload_thumb/";
  $target = null;
  $filename = null;
  $filenameprefix = "vp_";
  $photomaxwidth = 600;
  $photomaxheight = 400;
  $imageh = null;
  $imagew = null;
  $mytempimage = null;
  $thumbw = 100;
  $thumbh = 100;
  
  //kui klikiti submit, siis ...
if(isset($_POST["photosubmit"])){
	$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
	if($check !== false){
		//vardump[$_FILES]);
		if($check["mime"] == "image/jpeg"){
			$filetype = "jpg";
		}
		if($check["mime"] == "image/png"){
			$filetype = "png";
		}
		if($check["mime"] == "image/gif"){
			$filetype = "gif";
		}
	} else {
		$inputerror == "Valitud fail ei ole pilt! ";
	}
	if(empty($inputerror) and $_FILES["photoinput"]["size"] > $filesizelimit){
		$inputerror = "Liiga suur fail";
	}
	//loome uue failinime
	$timestamp = microtime(1) * 10000;
	$filename = $filenameprefix .$timestamp ."." .$filetype;
	//ega fail äkki olemas pole
	if(file_exists($fotouploaddir_orig .$filename)){
		$inputerror= "Selline fail on juba olemas!";
	}
	//kui vigu pole
	if(empty($inputerror)){
		//muudame suuru
		$target =  $fotouploaddir_normal .$filename;
		if($filetype == "jpg") {
			$mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "gif") {
			$mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "png") {
			$mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
		}
	
  
	//teeme kindalks originaalsuuruse.
		$imagew = imagesx($mytempimage);
		$imageh = imagesy($mytempimage);

		if($imagew > $photomaxwidth and $imageh > $photomaxheight){
			if($imagew / $photomaxwidth > $imageh / $photomaxheight){
				$photosizeratio = $imagew / $photomaxwidth;
			} else {
				$photosizeratio = $imageh / $photomaxheight;
			}
			//arvutame uued mõõdud
			$newh = round($imageh / $photosizeratio);
			$neww = round($imagew / $photosizeratio);
			//teeme uue pikslikogumi
			$mynewtempimage = imagecreatetruecolor($neww, $newh);
			//kirjutame järelejäävad pklslid uuele pildile.
			imagecopyresampled($mynewtempimage, $mytempimage, 0, 0, 0, 0, $neww, $newh, $imagew, $imageh);
			//salvestame
			$notice .= saveimage($mynewtempimage, $filetype, $target);
			thumbnail($mytempimage);
			imagedestroy($mynewtempimage);
		} else {
			$notice .= saveimage($mytempimage, $filetype, $target);
			thumbnail($mytempimage);
		}
		if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fotouploaddir_orig .$filename)){
			$notice .= " Originaalpildi salvestamine õnnestus!";
		} else {
			$notice .= " Originaalpildi salvestamisel tekkis tõrge!";
		}
	}
}
	
	
function saveimage($mynewsave, $filetyppe, $loc){
	$notic = null;
	if($filetyppe == "jpg"){
		if(imagejpeg($mynewsave, $loc, 90)){
			$notic .= " Vähendatud pildi salvestamine õnnestus!";
		} else {
			$notic .= " Vähendatud pildi salvestamisel tekkis tõrge!";
		}
	}
	if($filetyppe == "png"){
		if(imagepng($mynewsave, $loc, 6)){
			$notic .= " Vähendatud pildi salvestamine õnnestus!";
		} else {
			$notic .= " Vähendatud pildi salvestamisel tekkis tõrge!";
		}
	}
	if($filetyppe == "gif"){
		if(imagegif($mynewsave, $loc)){
			$notic .= " Vähendatud pildi salvestamine õnnestus!  ";
		} else {
			$notic .= " Vähendatud pildi salvestamisel tekkis tõrge!";
		}
	}
	return $notic;
}
function thumbnail($mytempimg){
	$noticc = null;
	$imagew = imagesx($mytempimg);
	$imageh = imagesy($mytempimg);
	$thumbw = 100;
	$thumbh = 100;
	$thumb = "../photoupload_thumb/";
	$prefix = "thumb_";
	if($imagew > $thumbw and $imageh > $thumbh){
		if($imagew / $thumbw > $imageh / $thumbh){
			$photosizeratio = $imagew / $thumbw;
		} else {
			$photosizeratio = $imageh / $thumbh;
		}
		//arvutame uued mõõdud
		$newth = round($imageh / $photosizeratio);
		$newtw = round($imagew / $photosizeratio);
		//teeme uue pikslikogumi
		$mynewthumb = imagecreatetruecolor($newtw, $newth);
		//kirjutame järelejäävad pklslid uuele pildile.
		imagecopyresampled($mynewthumb, $mytempimg, 0, 0, 0, 0, $newtw, $newth, $imagew, $imageh);
		//salvestame
			if(imagejpeg($mynewthumb, $thumb .$prefix .microtime(1)*10000 .".jpg", 70)){
				$noticc .= " Thumbnaili salvestamine õnnestus!";
			} else {
				$noticc .= " Tekkis tõrge!";
			}
		imagedestroy($mynewthumb);
	return $noticc;
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

  <li><a href="home.php">Avaleht<a/></li>
  </ul>

  <hr>
  <h2>Lisa uus film!</h2>
  <br>
  <form method ="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
	<label for="photoinput">Vali pildifail</label>
	<input type="file" name="photoinput" id="photoinput" required>
	<input type="submit" name="photosubmit" value="Lae foto üles">
	<br>
	<label for "altinput">Lisa pildi lühikirjeldus</label>
	<input id="altinput" name="altinput" type="text">
	<br>
	<label>Privaatsustase</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1">
	<label for="privinput1">Privaatne (ainult ise näen)</label>
	<br>
	<input id="privinput2" name="privinput" type="radio" value="1">
	<label for="privinput2">Klubi liikmetele (sisseloginud kasutajad näevad)</label>	
		<br>
	<input id="privinput3" name="privinput" type="radio" value="1">
	<label for="privinput3">Avalik (kõik näevad)</label>
	<br>
	<br>
  </form>

  <p><?php 
		echo $inputerror;
		echo $notice;
		?></p>
</body>
</html>