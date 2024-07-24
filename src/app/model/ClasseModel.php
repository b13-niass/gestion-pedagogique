<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class ClasseModel extends Model
{
    public function filiere()
    {
        return $this->belongsTo("FiliereEntity");
    }

    public function niveau()
    {
        return $this->belongsTo("NiveauEntity");
    }

    public function courclasses()
    {
        return $this->hasMany("CourclasseEntity");
    }
}