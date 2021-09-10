<?php

function chargeMemberClasses($classe):void
{
  if(file_exists(PLUGINS_PATH.'/members/class/'. ucfirst($classe) . '.php')){
    require PLUGINS_PATH.'/members/class/'. ucfirst($classe) . '.php';
  }
}
spl_autoload_register('chargeMemberClasses');

//Member-------
function memberOnly(object $member, string $redirection):void
{
    if ($member->getPermission() == 'visitor') {
        redirect($redirection);
    }
}


function connecting(): object
{
    if (isset($_SESSION['member'])) {
        return new Member($_SESSION['member']);
    } /* 1234 == ID   1235 == passtemp */
    elseif (isset($_COOKIE['1234']) AND isset($_COOKIE['1235'])) {
        $id = htmlspecialchars($_COOKIE['1234']);
        $passwordtemp = htmlspecialchars($_COOKIE['1235']);
        $memberAdministrator = new MemberManager();
        return $memberAdministrator->connexionCookie($id, $passwordtemp);
    } else {
        return new Member([]);
    }
}



function connectForm($_POST){
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
}
