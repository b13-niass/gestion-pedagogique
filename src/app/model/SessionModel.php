<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class SessionModel extends Model
{
    public function salle(){
        return $this->belongsTo("SalleEntity");
    }

    public function demandes()
    {
        return $this->hasMany("DemandeannulationEntity");
    }
    public function presences(){
        return $this->hasMany("PresenceEntity");
    }

}