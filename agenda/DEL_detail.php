<?php
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/configuration.php';
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/models/contactsmodel.php';
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/functions.php';
    try {
	$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
	echo 'ERRORE: ' . $e->getMessage();
    }
    $id = (int) $_GET['id'];
    $contactDB = new contacts($db);
    $row = $contactDB->searchSingleContact($id);
    //print_r($record);
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/details.php';
    $contactDB = null;
    $db = null;
?>