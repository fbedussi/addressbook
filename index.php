<?php

include $_SERVER['DOCUMENT_ROOT']."/addressbook/configuration.php";
include $_SERVER['DOCUMENT_ROOT'].'/addressbook/functions.php';
include $_SERVER['DOCUMENT_ROOT'].'/addressbook/users/models/usermodel.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERRORE: ' . $e->getMessage();
}

$user = new User($db);

session_start();

if (isset($_GET['logout']) && ($_GET['logout'] == 1))
{
    session_destroy();
    unset($_SESSION['username']);
}

//if the login has not took place
if (!isset($_SESSION['username']))
{
    //if the login form has been filled up
    if (isset($_POST['user']) && isset($_POST['pwd']))
    {
        if (password_verify($_POST['pwd'],$user->getUserPwdHash($_POST['user'])))
        {
            $_SESSION['username']=$_POST['user'];
            $_SESSION['admin'] = ($user->isAdministrator($_POST['user'])) ? "yes" : null;
            $_POST= array();
            include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/header.php";
            include $_SERVER['DOCUMENT_ROOT']."/addressbook/agenda/agenda.php";    
        } 
        else print("<p class=\"message\">Credenziali sbagliate, riprova</p>");
    } else {//otwrwise show the login form
        include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/header.php";
        include $_SERVER['DOCUMENT_ROOT'].'/addressbook/login.php';
        include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/footer.php";
    }
} else {
    if (empty($_GET) && empty ($_POST ))
    {
        include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/header.php";
    }
    
    include $_SERVER['DOCUMENT_ROOT']."/addressbook/agenda/agenda.php";    
    
}

$db=null;


?>