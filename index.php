<?php

//call function files (include automatic class call)
require_once ('config/config.php');
require_once (FUNCTIONS_PATH.'functions.php');

//Initialise session AFTER class initialisation
session_start();

//Show error if in local (127.0.0.1||localhost)
ini_set('display_error', devOrProd());
set_error_handler('errorPHP', E_ALL);


//plugins
$pluginsForm = false; // No forms treatment on plugins
$plugins= scandir(PLUGINS_PATH);
debug($plugins);
foreach ($plugins as $plugin) {
  // code...
  if(file_exists(PLUGINS_PATH.$plugin.'/'.$plugin.'.php')){
    include (PLUGINS_PATH.$plugin.'/'.$plugin.'.php');
  }
}


var_dump($member);
die();

//prepare the view
$openingPage = (isset($_GET['url']) AND !empty($_GET['url']) ) ? trim($_GET['url']) : 'home' ;
$title = $openingPage;

//Cherche dans l'ordre: Le controlleur et sa vue.
//Puis une vue si pas de controleur
//Puis un formulaire /!\ bloque l'affichage du footer ! Un formulaire n'est pas une vue
//Sinon erreur 404, affichage de la page d'erreur 404
if (file_exists(CONTROLLER_PATH.''.$openingPage.'.php')){
    require(CONTROLLER_PATH.''.$openingPage.'.php');
    if(file_exists(PARTIAL_PATH.'_'.$openingPage.'.phtml')){
        require (CONTROLLER_PATH.'header.php');
        require (PARTIAL_PATH.'_'.$openingPage.'.phtml');
    }
}
elseif (file_exists(PARTIAL_PATH.'_'.$openingPage.'.phtml'))
{
    require (CONTROLLER_PATH.'header.php');
    require(PARTIAL_PATH.'_'.$openingPage.'.phtml');
}
elseif (file_exists(FORMS_PATH.''.$openingPage.'.php'))
{
    require (FORMS_PATH.''.$openingPage.'.php');
    die();
}
elseif ($pluginsForm) {
  // code...
  foreach ($plugins as $plugin) {
    // code...
    if(file_exists(PLUGINS_PATH.$plugin.'/forms/'.$openingPage.'.php')){
      require (PLUGINS_PATH.$plugin.'/forms/'.$openingPage.'.php');
    }
  }
}
else{
    header('HTTP/1.0 404 Not Found');
    require (CONTROLLER_PATH.'header.php');
    require (PARTIAL_PATH.'_404.phtml');
}

require(PARTIAL_PATH . '_footer.phtml');
