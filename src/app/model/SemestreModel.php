<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class SemestreModel extends Model
{
    public function semestreannees(){
        return $this->hasMany("SemestreanneeEntity");
    }
}