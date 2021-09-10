<?php

//A remplir:
$localRepository = 'baseMember';
$localMail = 'mouii@live.ru';

$cheezpaRepository = '';
$cheezpaMail = 'mouii@live.ru';

$finalrepository = '';//Ne pas toucher si sur la racine
$finalMail = '';// Mail du client

//Suite ligne 80 !!!!-----------------

if ($_SERVER['HTTP_HOST'] == '127.0.0.1' OR $_SERVER['HTTP_HOST'] == 'localhost') {
    $host = 'http://' . $_SERVER['HTTP_HOST'] . "/$localRepository/";
    $racine_srv = $_SERVER['DOCUMENT_ROOT'] . "/$localRepository/";
    $adresseMail = $localMail;
    $state_DEV = 'dev';
} elseif ($_SERVER['HTTP_HOST'] == 'cheezpa.com') {
    $host = 'https://' . $_SERVER['HTTP_HOST'] . "/$cheezpaRepository/";
    $racine_srv = $_SERVER['DOCUMENT_ROOT'] . "/$cheezpaRepository/";
    $adresseMail = $cheezpaMail;
    $state_DEV = 'dev';
} else {
    $host = 'https://' . $_SERVER['HTTP_HOST'] . "/$finalrepository/";
    $racine_srv = $_SERVER['DOCUMENT_ROOT'] . "/$finalrepository/";
    $adresseMail = $finalMail;
    $state_DEV = 'prod';
}



$functions_path = $racine_srv . 'functions/';
//Lien en 127.0.0.1/...
$functions_URL = $host . 'functions/';

$controleur_path = $racine_srv.'controleurs/';

$class_url = $host . 'class/';
$class_path = $racine_srv . 'class/';

$images_path = $racine_srv . 'images/';
$images_URL = $host . 'images/';

$imagesPortable_URL = $images_URL.'portable/';
$imagesTablette_URL = $images_URL.'tablette/';
$imagesfixe_URL = $images_URL.'fixe/';

$partial_PATH = $racine_srv . 'partials/';

$form_path = $racine_srv.'forms/';
$css_URL = $host.'css/';

$js_URL = $host.'js/';

$plugins_Path = $racine_srv.'plugins/';




// constante:
define("HOST", $host);
define("RACINE_SRV", $racine_srv);
define("FUNCTIONS_PATH", $functions_path);
define("FUNCTIONS_URL", $functions_URL);
define("CONTROLLER_PATH", $controleur_path);
define("CLASS_URL", $class_url);
define("CLASS_PATH", $class_path);

define("IMAGES_PATH", $images_path);
define("IMAGES_URL", $images_URL);
define('IMAGE_PORTABLE_URL', $imagesPortable_URL);
define("IMAGE_TABLETTE_URL", $imagesTablette_URL);
define("IMAGE_FIXE_URL", $imagesfixe_URL);

define("PARTIAL_PATH", $partial_PATH);
define("FORMS_PATH", $form_path);
define("ADRESSEMAIL", $adresseMail);
define("CSS_URL", $css_URL);
define("JS_URL", $js_URL);
define("PLUGINS_PATH", $plugins_Path);

define("STATE_DEV", $state_DEV);



// BDD
if ($_SERVER['HTTP_HOST'] == '127.0.0.1' OR $_SERVER['HTTP_HOST'] == 'localhost') {
    $bddDomaine = 'localhost';
    $bddNom = 'basemember';
    $bddLogin = 'root';
    $bddMDP = '';
}
elseif ($_SERVER['HTTP_HOST'] == 'cheezpa.com') {
    include_once '../../bdd/bdd.php';
}
else {
    $bddDomaine = '';
    $bddNom = '';
    $bddLogin = '';
    $bddMDP = '';
}

// Constante pour la BDD
define("BDD_DOMAINE", $bddDomaine);
define("BDD_NOM", $bddNom);
define("BDD_LOGIN", $bddLogin);
define("BDD_MDP", $bddMDP);
