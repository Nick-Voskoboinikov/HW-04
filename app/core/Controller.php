<?php

namespace App\core;

interface IAuthController {
    public function register();
    public function login();
    public function logout();
}

interface IController{
    public function index();
}

class Controller implements IController {
    protected $view;
    public function __construct(){
        $this->view = new View();
    }
    static public function seasonWithSalt($strPass,$strSalt='predef1n3D_$4I^', $algo='gost-crypto'){
        if (mb_strlen($strPass) == 0){
                $strOut=$strSalt;
        } else {
        $strOut=mb_strlen($strPass);
            switch ($strOut % 2) {
            case 0:
                $strOut/=2;
                break;
            case $strOut % 2 == 1:
                $strOut=(floor($strOut/2)) + 1;
                break;
            default:
                $strOut/=2;
            }
        $strOut = mb_str_split($strPass,$strOut);
        $strOut = $strOut[0] . $strSalt . $strOut[1];
        }
        $strHashed=hash($algo, $strOut );
        $strOut=preg_replace('/(.).{3}/', '$1', $strHashed); // shrink it a bit... get every 1st out of 4-char group
        
        // return $strHashed; // just hashed
        return $strOut; // hashed and shrinked
    }
     
    public function index(){}

}


