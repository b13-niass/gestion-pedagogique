<?php
namespace GPD\App\Model;
use GPD\App\App;
use GPD\Core\Model\Model;

class UtilisateurModel extends Model{

    public function connection($email){
        return App::getSecurityDB()->getUser($email);
    }

    public function professeurs()
    {
        return $this->hasMany("ProfesseurEntity");
    }

    public function etudiants()
    {
        return $this->hasMany("EtudiantEntity");
    }

    public function getOneProfesseur($id){
        $this->getEntity()->id = $id;
        foreach ($this->professeurs as $professeur){
//        dd($professeur);
            if ($professeur->getEntity()->utilisateur_id == $id){
                return $professeur->getEntity();
            }
        }
    }

    public function getOneEtudiant($id){
        $this->getEntity()->id = $id;
        foreach ($this->etudiants as $etudiant){
            if ($etudiant->getEntity()->utilisateur_id == $id){
                return $etudiant->getEntity();
            }
        }
    }
}