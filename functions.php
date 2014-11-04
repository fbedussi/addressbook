<?php
function formatData($data,$format)
{
    //if it is an email address add the link
    if (strpos($data,'@'))
    {
        $emailAdresses = explode(' ',$data);
        foreach ($emailAdresses as $emailAddress)
        { 
            $emailAddress = trim($emailAddress); 
            return "<a class=\"email-address\" href=\"mailto:".$emailAddress."\">".$emailAddress."</a>";
        } 
    }
    else //otherwise 
    {
        //if format is boolean translate the YES/NO
	if ($format == 'boolean')
	{
	    return $data == 'yes'? YES : NO;
	} else { //oterwise simply print the data sustituiting HTML entities
	    return (empty($data))? "&nbsp;" : htmlentities($data);
	}
	
    }  
}


function mailchimpPlugin($name, $surname, $email)
{
	//combina nome e cogome, se ci sono entrambi inserisce uno spazio in mezzo
	if (($name !="") || ($surname !="")) {
		if ($name != "") {$name = $name . " ";}
		$name_and_surname = $name . $surname;
		$mergeVars = array(
			'FNAME'=> $name_and_surname
		);	
	}
	
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/addressbook/MCAPI.class.php');

	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI('217e62c2f708f1b469c5ccb1a022c45e-us4');

	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
	$list_id = "5d248807c9";
	
	// Send the form content to MailChimp List without double opt-in
	$retval = $api->listSubscribe($list_id, $email, $mergeVars, 'html', false);
	
	if ($api->errorCode){
		echo "Unable to load listSubscribe()!\n";
		echo "\tCode=".$api->errorCode."\n";
		echo "\tMsg=".$api->errorMessage."\n";
	} else {
		echo "<p class=\"message\">Contatto inserito nella newsletter!</p>\n";
	}
}
?>