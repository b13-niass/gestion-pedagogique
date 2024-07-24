<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class CourclasseModel extends Model
{
    public function cour(){
        return $this->belongsTo("CourEntity");
    }
    public function classe(){
        return $this->belongsTo("ClasseEntity");
    }
}