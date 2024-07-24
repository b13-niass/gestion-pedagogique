<?php

namespace GPD\App\Controller;

use GPD\App\App;
use GPD\App\Model\CourModel;
use GPD\App\Model\ProfesseurModel;
use GPD\App\Model\UtilisateurModel;
use GPD\Core\Controller;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IPaginator;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class ProfesseurController extends Controller
{
    private CourModel $courModel;
    private UtilisateurModel $utilisateurModel;
    private ProfesseurModel $professeurModel;

    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize,$paginator);
        $this->layout = "professeur_layout";
        $this->courModel = App::getInstance()->getModel("Cour");
        $this->utilisateurModel = App::getInstance()->getModel("Utilisateur");
        $this->professeurModel = App::getInstance()->getModel("Professeur");
    }

    public function index($idProf){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idProf!= $user->id){
                $this->redirect("/prof/{$user->id}");
            }
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $cours = $this->professeurModel->getCoursByProfesseur($professeur->id);
            $data['cours'] = $this->professeurModel->coursWithInfo($cours);
//            dd($data['cours']);
        }
        $this->renderView('/professeur/index', $data);
    }
    public function indexCalendar($idProf){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idProf!= $user->id){
                $this->redirect("/prof/{$user->id}");
            }
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $this->professeurModel->getEntity()->id = $professeur->id;

            $cours = $this->professeurModel->getCoursByProfesseur($professeur->id);
            $data['sessions'] = $this->professeurModel->getProfSessions($cours);
        }
        $this->renderView('/professeur/index_calendar', $data);
    }
    public function detailsCours($idProf, $idCours){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idProf!= $user->id){
                $this->redirect("/prof/{$user->id}");
            }
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $courModel = $this->professeurModel->getOneCourByProfesseur($professeur->id, $idCours);
            $data['cour'] = $courModel->getEntity();
        }
        $this->renderView('/professeur/details_cours', $data);
    }
    public function listeSession($idProf, $idCours){
        $data = [];
//        dd(1);
//        dd([$idProf, $idCours]);
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
//            if($idProf!= $user->id){
//                $this->redirect("/prof/{$user->id}");
//            }
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $courModel = $this->professeurModel->getOneCourByProfesseur($professeur->id, $idCours);
//            dd($courModel->getSessions());
            $data['cour'] = $courModel->getEntity();
        }
        $this->renderView('/professeur/liste_sessions', $data);
    }
}