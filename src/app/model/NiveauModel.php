<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class NiveauModel extends Model
{
    public function classes()
    {
        return $this->hasMany("ClasseEntity");
    }
}