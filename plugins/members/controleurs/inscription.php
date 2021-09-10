<?php

if($member->isIdentify()){
    redirect('home');
}

$error = getErrors('inscription');