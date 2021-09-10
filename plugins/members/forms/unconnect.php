<?php


$_SESSION=[];
unset($_SESSION);
setcookie('1234', '1', time() -1, '/', $_SERVER['HTTP_HOST'], false, true);
setcookie('1235', '1', time() -1, '/', $_SERVER['HTTP_HOST'], false, true);

redirect('home');