<head>
  <meta charset="utf-8">
  <title><?php if(isset($username)){echo $username;}?>TLU 2020</title>
  <style>
  <?php
    echo "body { \n";
	if(isset($_SESSION["userbgcolor"])){
		echo "\t \t background-color: " .$_SESSION["userbgcolor"] ."; \n";
	} else {
		echo "\t \t background-color: #FFFFFF; \n";
	}
	if(isset($_SESSION["usertxtcolor"])){
		echo "\t \t color: " .$_SESSION["usertxtcolor"] ."; \n";
	} else {
		echo "\t \t color: #000000; \n";
	}
	echo "\t ; \n ";
	echo "}";
  ?>
  </style>
</head>