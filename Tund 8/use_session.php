<?php

  session_start();






































  if(!isset($_SESSION["userid"])){
	//jõuga suunatakse sisselogimise lehele
	header("Location: page.php");
	exit();
  }  
  if(isset($_GET["logout"])){
    //kustutame sessiooni
	session_destroy();
	//jõuga suunatakse sisselogimise lehele
	header("Location: page.php");
	exit();
  }