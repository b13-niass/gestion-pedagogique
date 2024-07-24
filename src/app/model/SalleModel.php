<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class SalleModel extends Model
{
    public function sessions(){
        return $this->hasMany("SessionEntity");
    }
}