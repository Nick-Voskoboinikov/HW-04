<?php

namespace App\models;

class User {
    public string $username;
    public string $password;
    public \DateTime $created;

    public function __construct($entity) 
    {
        $this->username = $entity->username;
        $this->password = \App\core\Controller::seasonWithSalt($entity->password);
        if (\App\data\DB::getAdminsNum()){
            $this->role = 1;
        } else {
            $this->role = 5; // First user gets admin priviliges
        }
        $this->email = $entity->email;
        $this->created = \DateTime::createFromFormat('U', time());
        $this->hash = '';

    }
}