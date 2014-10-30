<?php
  include $_SERVER['DOCUMENT_ROOT']."/addressbook/configuration.php";
  include $_SERVER['DOCUMENT_ROOT'].'/addressbook/functions.php';
  include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/models/contactsmodel.php';
  
  try {
      $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
      echo 'ERRORE: ' . $e->getMessage();
  }

session_start();
	
	$contactDB = new contacts($db);
	
	$results = $_SESSION['results'];
	$size = $_GET['size'];
	include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/envelope.php';
	
	$contactDB = nul;
	$db = nul;
?>