<?php
    //data base
    $host = '62.149.150.50';
    $dbname = 'Sql95158_2';
    $username = 'Sql95158';
    $password = '4988754f';
    
    //localisation
    $language = 'it-IT';
    
    switch ($language) {
    case 'it-IT':
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/language/it_IT.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/language/it_IT.php';
}
    
    //fields
    //visible=1 > the column is displayed both in the SERP and in the single record view
    //visible=0 > the column is displayed only in the single record view
    //searchable=1 > display the filed il the search box
    //searchable=0 > do not display the filed il the search box
    //format=dropdown > loads values from the section named after the column label in the language/dropdown_[language code].ini file
    
    //WARNING: the order of the array elements MUST be the SAME of the order of the columns in the DB
    $columns = array (
        //do not edit this fields they are used by default
	   "createdate"    => array ("label" => CREATE_DATE, "format" => "date", "visible" => 0, "searchable" => 0, "searchable-mobile" => 0),
        "createdby"     => array ("label" => CREATED_BY, "format" => "string", "visible" => 0, "searchable" => 0, "searchable-mobile" => 0),
        "editdate"      => array ("label" => EDIT_DATE, "format" => "string", "visible" => 0, "searchable" => 0, "searchable-mobile" => 0),
        "editedby"        => array ("label" => EDIT_BY, "format" => "date", "visible" => 0, "searchable" => 0, "searchable-mobile" => 0),
        
	   //editable fields
	   "newsletter"    => array ("label" => NEWSLETTER, "format" => "boolean", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "title"         => array ("label" => TITLE, "format" => "dropdown", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "name"          => array ("label" => NAME, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 1),
        "surname"       => array ("label" => SURNAME, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 1),
        "organisation"  => array ("label" => ORGANISATION, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 1),
        "role"          => array ("label" => ROLE, "format" => "string", "visible" => 0, "searchable" => 1, "searchable-mobile" => 1),
        "phone"         => array ("label" => PHONE, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "mobile"        => array ("label" => MOBILE, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "fax"           => array ("label" => FAX, "format" => "string", "visible" => 0, "searchable" => 1, "searchable-mobile" => 0),
        "email"         => array ("label" => EMAIL, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "address"       => array ("label" => ADDRESS, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 0),
        "city"          => array ("label" => CITY, "format" => "string", "visible" => 1, "searchable" => 1, "searchable-mobile" => 1),
        "province"      => array ("label" => PROVINCE, "format" => "string", "visible" => 0, "searchable" => 1, "searchable-mobile" => 0),
        "zip"           => array ("label" => ZIP, "format" => "integer", "visible" => 0, "searchable" => 1, "searchable-mobile" => 0),
        "note"          => array ("label" => NOTE, "format" => "text", "visible" => 1, "searchable" => 1, "searchable-mobile" => 1)
    );
    
    $addressFormat = array (
        "title", " ", "name", " ", "surname", "line",
        "organisation", "line",
        "zip", " ", "city", " ", "(", "province",")","line"   
    );
    $template = 'default';
    
    $logo = 'logo.jpg';
    
?>