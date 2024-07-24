<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class ProfesseurModel extends Model
{
    public function cours()
    {
        return $this->hasMany("CourEntity");
    }

    public function utilisateur()
    {
        return $this->belongsTo("UtilisateurEntity");
    }

    public function getCoursByProfesseur($id){
        $this->getEntity()->id = $id;
        $cours = [];
        foreach ($this->cours as $cour){
            if ($cour->getEntity()->professeur_id == $id){
                $cours[] = $cour;
            }
        }
        return $cours;
    }

    public function getOneCourByProfesseur($idProf, $idCour)
    {
        $cours = $this->getCoursByProfesseur($idProf);
        foreach ($cours as $cour){
            if ($cour->getEntity()->id == $idCour){
                return $cour;
            }
        }
    }

    public function getCourModule(CourModel $cour){
//        dd($cour->module);
        return $cour->module->getEntity()->libelle;
    }

    public function getCourSemestre(CourModel $cour){
        return $cour->semestre->getEntity()->libelle;
    }

    public function getCourAnnee(CourModel $cour){
        return $cour->annee->getEntity()->libelle;
    }

    public function getCourClasses(CourModel $cour){
        $classes = [];
        foreach ($cour->courclasses as $classe){
            $classes[] = $classe->classe->getEntity();
        }
        return $classes;
    }

    public function coursWithInfo(array $cours){
        $result = [];
        foreach ($cours as $cour){
//            dd($this->getCourModule($cour));
            $cour->getEntity()->module_name = $this->getCourModule($cour);
            $cour->getEntity()->semestre_name = $this->getCourSemestre($cour);
            $cour->getEntity()->annee_name = $this->getCourAnnee($cour);
            $cour->getEntity()->classes =  $this->getCourClasses($cour);
           $result[] = $cour->getEntity();
        }
        return $result;
    }

    public function getProfSessions(array $cours){
        $sessions = [];
//        return $cours[0]->getSessions();
        foreach ($cours as $cour){
            $sessions = array_merge($sessions, $cour->getSessions());
        }
        return $sessions;
    }
}