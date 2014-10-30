<?php
    session_start();
    
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/configuration.php';
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/models/contactsmodel.php';
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/functions.php';
    try {
	$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
	echo 'ERRORE: ' . $e->getMessage();
    }
    $contactDB = new contacts($db);
    
   
    
    if (isset($_POST['add']) && ($_POST['add'] == 1))
    {
	$contactFields = array();
        foreach ($_POST as $label => $value)
        {
            //select form the POST array the values that are part of the DB
            if (array_key_exists($label,$columns) && $value)
            {
		//sanitise input
		$value = trim(filter_var($value,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
	    
		if (!empty($value))
		{
		    $contactFields[] = array('field' => $label,'term' => $value);
		}
	    
            }
        }
        
        //print_r($contctFields);
        $id = $contactDB->insertContact($contactFields);
	
	$results = $contactDB->searchContacts($_SESSION['searchFields']);
    
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
	
    } else {
	include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/add.php';
    }
    
    $contactDB = null;
    $db = null;
?>