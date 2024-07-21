<?php

namespace GPD\App\Controller;

use GPD\App\App;
use GPD\Core\Controller;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IPaginator;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class ProfesseurController extends Controller
{
    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize,$paginator);
        $this->layout = "professeur_layout";
    }

    public function index($idProf){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
        }
        $this->renderView('/professeur/index', $data);
    }
    public function detailsCours($idProf, $idCours){
        $this->renderView('/professeur/details_cours');
    }
    public function listeSession($idProf, $idCours){
        $this->renderView('/professeur/liste_sessions');
    }
}