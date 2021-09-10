<?php

class BDD
{
    protected $_bdd;

    public  function __construct()
    {
        $bddDomaine = BDD_DOMAINE;
        $bddNom = BDD_NOM;
        $bddLogin = BDD_LOGIN;
        $bddMDP = BDD_MDP;
        $bddHost= "mysql:host=$bddDomaine;dbname=$bddNom;charset=utf8";

        try {
            $this->_bdd = new PDO($bddHost, $bddLogin, $bddMDP, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $this->_bdd;
        }
        catch (exeption $e){
            die('erreur : ' . $e->$getmessage());
        }
    }
}