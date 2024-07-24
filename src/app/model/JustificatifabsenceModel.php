<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class JustificatifabsenceModel extends Model
{
    public function session(){
        return $this->belongsTo("SessionEntity");
    }
}