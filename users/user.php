<?php

include $_SERVER['DOCUMENT_ROOT']."/addressbook/configuration.php";
include $_SERVER['DOCUMENT_ROOT']."/addressbook/users/models/usermodel.php";

session_start();

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERRORE: ' . $e->getMessage();
}


// Create an instance
$user = new User($db);

include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/header.php";

if (isset($_GET['del'])) {
    $user->getUser(htmlspecialchars($_GET['id']));
    include 'views/confirm.php';
}

if (isset($_GET['confirmdel'])) {
    $user->deleteUser(htmlspecialchars($_GET["id"]));
}

if (isset($_POST['add'])) {
    if ($_POST['pwd']==$_POST['confirmPwd']) {
        $user->insertUser(htmlspecialchars($_POST['name']),htmlspecialchars($_POST['pwd']));    
    } else {
        include 'views/error.php';
    }
    
}

if (isset($_POST['edited'])) {
    $user->updateUser(htmlspecialchars($_GET['id']),htmlspecialchars($_POST['name']),htmlspecialchars($_POST['pwd']));
}

// Show a view
if (isset($_GET['edit'])) {
    $user->getUser(htmlspecialchars($_GET['id']));
    include 'views/edituser.php';
} else {
    $allUser = $user->getAllUsers();
    include 'views/userlist.php';
}


include $_SERVER['DOCUMENT_ROOT']."/addressbook/template/$template/footer.php";

$db = null;
$user = null;
?>