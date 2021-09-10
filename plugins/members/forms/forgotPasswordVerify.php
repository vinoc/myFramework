<?php


$login = (isset($_POST['login']))? $_POST['login']: '';
$mailAdress= (isset($_POST['mailAdress']))? $_POST['mailAdress']: '';

$memberManager = new MemberManager();
$distractedUser = new Member([]);
if($login !=''){
    $distractedUser = $memberManager->getMemberByLogin($login);
}

if($mailAdress != ''){
    $distractedUser = $memberManager->getMemberByMailAdress($mailAdress);
}

//If member found: Send mail
if( $distractedUser->getID() !=null ){

    $distractCode= uniqid('', true);
    $link=HOST.'distractedUser?code='.$distractCode;


    $mail= [];
    $mail['message'] = "Bonjour, <br>Vous avez oublié votre mot de passe, pas de panique, cela arrive. <br>Merci de cliquer sur ce lien ou de le copier dans votre navigateur pour créer un nouveau mot de passe<br>".$link;

    $mail['recipient'] = $distractedUser->getMailAdress();
    $mail['subject'] = 'Blue point : Mot de passe';
    $mail = new Mail($mail);
    $mail->sendMail();

    $memberManager->distractedMember($distractedUser, $distractCode);
}

echo 'Si un compte existe avec ces informations, un mail a été envoyé à l\'adresse enregistré. Veuillez consulter votre boite mail.';