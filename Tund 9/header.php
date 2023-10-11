<head>
  <meta charset="utf-8">
  <title><?php if(isset($_SESSION["userfirstname"]) and isset($_SESSION["userlastname"])){echo "Hello, " .$_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];}?></title>
  <style>
  <?php
    echo "body { \n";
	if($filetype == "jpg"){
			$mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "png"){
			$mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "gif"){
			$mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
		}
	echo "\t ; \n ";
	echo "}";
  ?>
  </style>
</head>