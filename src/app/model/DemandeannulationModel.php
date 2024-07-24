<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class DemandeannulationModel extends Model
{
    public function session(){
        return $this->belongsTo("SessionEntity");
    }

}