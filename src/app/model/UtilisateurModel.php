<?php
namespace GPD\App\Model;
use GPD\App\App;
use GPD\Core\Model\Model;

class UtilisateurModel extends Model{
    
    public function dettes(){
        return $this->hasMany('DetteEntity');
    }

    public function connection($email){
        return App::getSecurityDB()->getUser($email);
    }

}