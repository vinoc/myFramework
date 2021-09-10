<?php


$_SESSION['errors'] = [];
if ($member->getIdentify()== true){
    redirect('admini');
}


if (!isset($_POST['login']) OR $_POST['login'] == ''){
    $_SESSION['errors']['login'] = true;
}


if (!isset($_POST['password']) OR $_POST['password'] == ''){
    $_SESSION['errors']['password'] = true;
}


if (!isset($_POST)){
    $_SESSION['errors']['login'] = true;
    $_SESSION['errors']['password'] = true;

    redirect('connexion');
}


if($_SESSION['errors'] !== []){
    redirect('connexion');
}

$login = htmlspecialchars($_POST['login']);
$password = $_POST['password'];


$memberAdministrator = new MemberManager();

if ($memberAdministrator->connectionLogin($login, $password) == false){
    $_SESSION['errors']['connexion'] = true;
    redirect('connexion');
}
else{
    redirect('admini');
}
