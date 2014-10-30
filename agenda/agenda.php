<?php

// Include the model
include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/models/contactsmodel.php';




$contactDB = new contacts($db);


//show serchbox only if the script is executed without GET parameters
if (empty($_GET) && empty ($_POST ))
{
    
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchbox.php';
}

//RESET search form
if (isset($_GET['reset']) && ($_GET['reset'] == 1))
    {
        $_GET = array();
        $_POST = array();
        unset($_SESSION['searchFields']);
        $results = array();
    }

//DELETE or COPY single contact
if (isset($_GET['action']) && isset($_GET['id']))
{
    switch ($_GET['action'])
    {
        case 'del':
            $contactDB->deleteContacts(array(0 => (int)$_GET['id']));
        case 'copy':
            $contactDB->copyContact((int) $_GET['id']);
        default:
            $results = $contactDB->searchContacts($_SESSION['searchFields']);
            include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
    }
}

//DETAIL
if (isset($_GET['detail']) && ($_GET['detail'] == 1))
{
    $id = (int) $_GET['id'];
    $row = $contactDB->searchSingleContact($id);
    unset($_GET['detail']);
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/details.php';
}

//EDIT
//edit form
if (isset($_GET['edit']) && ($_GET['edit'] == 1))
{
    //get the ID
    $id = (int)$_GET['id'];

    //get the contact details
    $record = $contactDB->searchSingleContact($id);
    
    //ad display them
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/edit.php';
}
    
//SAVE the EDIT
if (isset($_POST['edit']) && ($_POST['edit'] == 1) && isset($_POST['id']))
{
    unset($_GET['edit']);
    $contactFields = array();
    foreach ($_POST as $label => $value)
    {
        //select form the POST array the values that are part of the DB
        if (array_key_exists($label,$columns) && $value)
        {
            //sanitise input
            $value = trim(filter_var($value,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
            
            //convert carriage return
            //if ($columns[$label]['format'] == 'text')
            //{
            //    $value = preg_match("/\r\n|\n|\r/", "<br />", $value);    
            //}
        
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
} 

//Display ADD form
if (isset($_GET['add']) && ($_GET['add'] == 1))
{
    unset($_GET['add']);
    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/add.php';
}

//ADD contact
if (isset($_POST['add']) && ($_POST['add'] == 1))
{
    unset($_POST['add']);
    $contactFields = array();
    foreach ($_POST as $label => $value)
    {
        //select form the POST array the values that are part of the DB
        if (array_key_exists($label,$columns) && $value);
        {
            //sanitise input
            $value = trim(filter_var($value,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
            
            //convert carriage return
            if ($columns[$label]['format'] == 'text')
            {
                $value = preg_match("/\r\n|\n|\r/", "<br />", $value);    
            }
            
            if (!empty($value))
            {
                $contactFields[] = array('field' => $label,'term' => $value);
            }
        
        }
    }
    
    //print_r($contctFields);
    $id = $contactDB->insertContact($contactFields);
    
    if (isset ($_SESSION['searchFields']))
    {
        $results = $contactDB->searchContacts($_SESSION['searchFields']);    
    } else {
        $results = $contactDB->searchContacts($contactFields);    
    }

    include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
}

//SEARCH
if (isset($_POST['search']) && ($_POST['search'] == 1))
    {
        //$SESSION['post'] = $_POST;
        $searchFields = array();
        foreach ($_POST as $label => $value)
        {
            //select form the POST array the values that are part of the DB
            if (array_key_exists($label,$columns) && $value)
            {
                //if there is a sentence between quotes extract it
                //print $value;
                $firstQuote = strpos($value,'"');
                $lastQuote = strrpos($value,'"');
                if ($firstQuote>=0 && $lastQuote>0)
                {
                    print "quotes";
                    $quotedString = filter_var(substr($value,$firstQuote+1,$lastQuote-1),FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
                    $searchFields[] = array('field' => $label, 'term' => $quotedString);
                    $value = trim(str_replace('"'.$quotedString.'"','',$value));
                }
                
                //if there is something left in the query
                if ($value != '')
                {
                    //sanitise input
                    $value = filter_var($value,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
                    
                    //explode search terms
                    $searchTerms = explode(' ', $value);
                    foreach ($searchTerms as $term)
                    {
                        $term = trim($term);
                        
                        if (!empty($term))
                        {
                            $searchFields[] = array('field' => $label,'term' => $term);
                        }
                    }
                }
            }
        }
        
        //print_r($searchFields);
        $_SESSION['searchFields'] = $searchFields;
        
        
        $results = $contactDB->searchContacts($searchFields);
        
        $_SESSION['results'] = $results;
        
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
    }    
    
//DELETE SELECTED & FILTER SELECTION   
if (isset($_POST['action']) && isset($_POST['id']))
{
    //explode IDs
    $ids = explode(',', $_POST['id']);
    
    switch ($_POST['action'])
    {
        case 'delall':
            $contactDB->deleteContacts($ids);
            $results = $contactDB->searchContacts($_SESSION['searchFields']);
        case 'select':
            $results = $contactDB->selectContacts($ids);
            $_SESSION['results'] = $results;
        default:
            include $_SERVER['DOCUMENT_ROOT'].'/addressbook/agenda/views/searchresults.php';
    }
    
    $_POST = array();
}

//include footer only if the script is executed without GET parameters
if (empty($_GET) && empty ($_POST ))
{
    include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/footer.php";
}

$contactDB = null;
?>