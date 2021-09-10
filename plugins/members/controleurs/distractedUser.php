<?php

if($member->isIdentify()){
    $error = 'impossible de réinitialisé un mot de passe lorsque vous êtes connecté';
}
else {
    $error = '';

    $distractedCode = (isset($_GET['code'])) ? $_GET['code'] : '';

    $memberManager = new MemberManager();

    $distractMember = $memberManager->findDistractedMemberByLinkCode($distractedCode);

    if($distractMember->getID() == 0){
        $error = 'votre lien semble expirer, veuillez refaire un rappel de mot de passe.';
    }
}

$_SESSION['distractMember'] = $distractMember;