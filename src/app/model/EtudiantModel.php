<?php
namespace GPD\App\Model;

use GPD\Core\Model\Model;

class EtudiantModel extends Model
{
    public function classe()
    {
        return $this->belongsTo("ClasseEntity");
    }

    public function utilisateur()
    {
        return $this->belongsTo("UtilisateurEntity");
    }

    public function getCoursByEtudiant($id){
        $this->getEntity()->classe_id = $id;
//        dd($this->classe);
        $cours = [];
        foreach ($this->classe->courclasses as $courclasse){
                $cours[] = $courclasse->cour;
        }
        return $cours;
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

    public function getEtudiantSessions(array $cours){
        $sessions = [];
        foreach ($cours as $cour){
            $sessions = array_merge($sessions, $cour->getCourSessionsModel());
        }
        return $sessions;
    }

    public function getEtudiantSessionsWithPresence(array $cours){
        $sessions = $this->getEtudiantSessions($cours);
        $sessions_with_presence = array();
        foreach ($sessions as $session){
            $cpt_presence = 0;
            foreach ($session->presences as $presence) {
//                return $presence->getEntity();
                if ($presence->getEntity()->etudiant_id == $this->getEntity()->id){
                    $cpt_presence++;
                    break;
                }
            }
            if ($cpt_presence){
                $session->getEntity()->presence = "present";
            }else{
                $session->getEntity()->presence = "absent";
            }
            $sessions_with_presence[] = $session->getEntity();
        }
        return $sessions_with_presence;
    }

    public function getEtudiantAbsenceWithJustificatif(array $cours){
        $sessions = $this->getEtudiantSessions($cours);
        $sessions_with_presence = array();
        foreach ($sessions as $session){
            $cpt_presence = 0;
            foreach ($session->presences as $presence) {
//                return $presence->getEntity();
                if ($presence->getEntity()->etudiant_id == $this->getEntity()->id){
                    $cpt_presence++;
                    break;
                }
            }
            if ($cpt_presence){
                $session->getEntity()->presence = "present";
            }else{
                $session->getEntity()->presence = "absent";
            }
            $sessions_with_presence[] = $session;
        }

        $sessions_with_justificatif = [];
        foreach ($sessions_with_presence as $session) {
            $cpt = 0;
            if($session->getEntity()->presence == "absent"){
                foreach ($session->justificatifs as $justif){
                    if ($session->getEntity()->id == $justif->getEntity()->session_id){
                        $cpt++;
                        break;
                    }
                }
            }

            if ($cpt){
                $session->getEntity()->justificatif = true;
            }else{
                $session->getEntity()->justificatif = false;
            }
            $sessions_with_justificatif[] = $session->getEntity();
        }
        return $sessions_with_justificatif;
    }


    public function coursWithInfo(array $cours){
        $result = [];
        foreach ($cours as $cour){
            $cour->getEntity()->module_name = $this->getCourModule($cour);
            $cour->getEntity()->semestre_name = $this->getCourSemestre($cour);
            $cour->getEntity()->annee_name = $this->getCourAnnee($cour);
            $cour->getEntity()->classes =  $this->getCourClasses($cour);
            $result[] = $cour->getEntity();
        }
        return $result;
    }

}