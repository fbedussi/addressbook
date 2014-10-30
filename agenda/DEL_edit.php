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
    
    //if the contact has been editied and the ID is set
    if (isset($_POST['edit']) && ($_POST['edit'] == 1) && isset($_POST['id']))
    {
	$contactFields = array();
        foreach ($_POST as $label => $value)
        {
            //select form the POST array the values that are part of the DB
            if (array_key_exists($label,$columns) && $value)
            {
		//sanitise input
		$value = trim(filter_var($value,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
	    
		//if there is something left add it to the array
		if (!empty($value))
		{
		    $contactFields[] = array('field' => $label,'term' => $value);
		}
	    
            }
        }
        
	//update the contact
        $contactDB->updateContact($contactFields,$_POST['id']);
	
	//renew the search
	$results = $contactDB->searchContacts($_SESSION['searchFields']);
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
    } else { //if the contact has not been edited yet
	
	//get the ID
	$id = (int)$_GET['id'];
    
	//get the contact details
	$record = $contactDB->searchSingleContact($id);
	
	//ad display them
	include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/edit.php';
    }
    
    //close DB connections
    $contactDB = null;
    $db = null;
?>