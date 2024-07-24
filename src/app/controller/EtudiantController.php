<?php

namespace GPD\App\Controller;

use GPD\App\App;
use GPD\App\Model\CourModel;
use GPD\App\Model\EtudiantModel;
use GPD\App\Model\ProfesseurModel;
use GPD\App\Model\SessionModel;
use GPD\App\Model\UtilisateurModel;
use GPD\Core\Controller;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IPaginator;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class EtudiantController extends Controller
{
    private CourModel $courModel;
    private UtilisateurModel $utilisateurModel;
    private ProfesseurModel $professeurModel;
    private EtudiantModel $etudiantModel;
    private SessionModel $sessionModel;

    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize,$paginator);
        $this->layout = "etudiant_layout";
        $this->courModel = App::getInstance()->getModel("Cour");
        $this->utilisateurModel = App::getInstance()->getModel("Utilisateur");
        $this->professeurModel = App::getInstance()->getModel("Professeur");
        $this->etudiantModel = App::getInstance()->getModel("Etudiant");
        $this->sessionModel = App::getInstance()->getModel("Session");
    }

    public function index($idEtu){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idEtu!= $user->id){
                $this->redirect("/etu/{$user->id}");
            }
//            $etudiant = $this->utilisateurModel->getOneEtudiant($user->id);
//            $this->etudiantModel->getEntity()->id = $etudiant->id;
        }
        $this->renderView('/etudiant/index', $data);
    }

    public function indexCours($idEtu){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idEtu!= $user->id){
                $this->redirect("/etu/{$user->id}");
            }
            $etudiant = $this->utilisateurModel->getOneEtudiant($user->id);
            $this->etudiantModel->getEntity()->id = $etudiant->id;
            $cours = $this->etudiantModel->getCoursByEtudiant($etudiant->classe_id);
            $data['cours'] = $this->etudiantModel->coursWithInfo($cours);
//            dd($data['cours']);
        }
        $this->renderView('/etudiant/liste_cours', $data);
    }
}