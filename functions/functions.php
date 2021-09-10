<?php

function getErrors(string $nomDuChamp): string
{
    if (empty($_SESSION['errors'][$nomDuChamp])) {
        return '';
    }
    $error = $_SESSION['errors'][$nomDuChamp];
    unset($_SESSION['errors'][$nomDuChamp]);
    return $error;
}

function chargeClasse($classe)
{
  if(file_exists('class/'.ucfirst($classe).'.php')){
    require 'class/' . ucfirst($classe) . '.php';
  }
}
spl_autoload_register('chargeClasse');

function redirect($location)
{
    header("location: " . HOST . "$location");
    die();
}

function debug($variable, $die = 0)
{
    var_dump($variable);

    if ($die == 1) {
        die();
    } else
        echo "<br />";
}

function devOrProd(): bool
{
    if (STATE_DEV == "dev") {
        return true;
    } else {
        return false;
    }
}

function errorPHP($err_severity, $err_msg, $err_file, $err_line, array $err_context)
{
    if (devOrProd()) {
        echo '<div class="error"><p> erreur N°' . $err_severity . '</p>
        <p>Message: ' . $err_msg . '</p>
        <p>fichier: ' . $err_file . '</p>
        <p>ligne: ' . $err_line . '</p>
        </div>';
    }
}
