<?php

//from disctractUser page, for people who forgot their password;
if(isset($_SESSION['distractMember'])) {
    if (isset($_POST['passwordNew']) AND $_POST['passwordNew'] !== '') {
        if (isset($_POST['passwordNewVerif']) AND $_POST['passwordNewVerif'] == $_POST['passwordNew']) {
            $distractMember = $_SESSION['distractMember'];
            $distractMember->setPassword($_POST['passwordNew']);
            $memberManager = new MemberManager();
            $memberManager->changeDistractPassword($distractMember);
        }
    }
    redirect('connexion');
}
//From compte page.
else {
    memberOnly($member, 'home');

    $memberUpdate = new Member($_POST);

    if (isset($_POST['passwordNew']) AND $_POST['passwordNew'] !== '') {
        if (isset($_POST['passwordNewVerif']) AND $_POST['passwordNewVerif'] == $_POST['passwordNew']) {
            if (!password_verify($_POST['password'], $member->getPassword())) {
                $_SESSION['errors']['update'] = 'L\'ancien mot de passe ne correspond pas';
                redirect('compte');
            }
            $memberUpdate->setPassword($_POST['passwordNewVerif']);
        } else {
            $_SESSION['errors']['update'] = 'Les mots de passe ne correspondent pas';
            redirect('compte');
        }
    }
    else{
        $memberUpdate->setPassword('null');
    }

    $memberManager = new MemberManager();
    if($memberManager->MemberUpdate($member, $memberUpdate)){
        $_SESSION['errors']['update'] = 'Information mises à jours';
        $_SESSION['member']['login'] = $memberUpdate->getLogin();
        $_SESSION['member']['mailAdress'] = $memberUpdate->getMailAdress();
    }
    else{
        $_SESSION['errors']['update'] = 'Une erreur est survenu veuillez retenter plus tard';
    }
    redirect('compte');
}