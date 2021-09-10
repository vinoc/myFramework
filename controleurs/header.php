<?php

$visible = 'visible';
$hidden = 'hidden';
$afficheBoutonDeconnexion = ($member->getIdentify()) ? $visible : $hidden;
$afficheBoutonConnexion = ($member->getIdentify()) ? $hidden : $visible;

$visibiliteAdmin = ($member->getPermission() ==  "admin" ) ? $visible : $hidden;

$urlMonCompte = ($member->getIdentify()) ?   HOST .'playerPage?id='.$member->getId() : 'home';

require (PARTIAL_PATH.'_header.phtml');