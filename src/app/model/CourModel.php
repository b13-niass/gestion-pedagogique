<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class CourModel extends Model
{
    public function professeur()
    {
        return $this->belongsTo("ProfesseurEntity");
    }

    public function sessions()
    {
        return $this->hasMany("SessionEntity");
    }

    public function classes()
    {
        return $this->belongsToMany("CourclasseEntity","ClasseEntity");
    }

    public function semestre()
    {
        return $this->belongsTo("SemestreEntity");
    }

    public function annee()
    {
        return $this->belongsTo("AnneescolaireEntity");
    }

    public function module()
    {
        return $this->belongsTo("ModuleEntity");
    }

    public function courclasses()
    {
        return $this->hasMany("CourclasseEntity");
    }

    public function getSessions(){
        $sessions = [];
        foreach ($this->sessions as $session){
            $session->getEntity()->module_name = $this->module->getEntity()->libelle;
            $sessions[] = $session->getEntity();
        }
        return $sessions;
    }

    public function getCourSessionsModel(){
        $sessions = [];
        foreach ($this->sessions as $session){
            $session->getEntity()->module_name = $this->module->getEntity()->libelle;
            $sessions[] = $session;
        }
        return $sessions;
    }

}