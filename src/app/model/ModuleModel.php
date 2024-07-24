<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class ModuleModel extends Model
{
    public function cours(){
        return $this->hasMany("CourEntity");
    }
}