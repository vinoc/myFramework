<?php
$pluginsForm = true;

require PLUGINS_PATH.'members/functions/functions.php';




//Preparing Member(user information)
$member = connecting();

if(isset($_POST['connect'])){
  connectForm($_POST);
}
