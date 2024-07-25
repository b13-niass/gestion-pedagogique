<?php

namespace GPD\App\Controller;

use GPD\App\App;
use GPD\App\Model\CourModel;
use GPD\App\Model\EtudiantModel;
use GPD\App\Model\JustificatifabsenceModel;
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
    private JustificatifabsenceModel $justifModel;

    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize,$paginator);
        $this->layout = "etudiant_layout";
        $this->courModel = App::getInstance()->getModel("Cour");
        $this->utilisateurModel = App::getInstance()->getModel("Utilisateur");
        $this->professeurModel = App::getInstance()->getModel("Professeur");
        $this->etudiantModel = App::getInstance()->getModel("Etudiant");
        $this->sessionModel = App::getInstance()->getModel("Session");
        $this->justifModel = App::getInstance()->getModel("Justificatifabsence");
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

    public function indexAbsence($idEtu){
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
//            $sessions = $this->etudiantModel->getEtudiantSessions($cours);
            $sessions = $this->etudiantModel->getEtudiantAbsenceWithJustificatif($cours);
            $sessions_with_absence = [];

            foreach($sessions as $session){
                if($session->presence == "absent" && $this->compareDateTimeEndWithNow($session->heureFin)){
                $sessions_with_absence[] = $session;
                }
            }
//            dd($sessions_with_absence);
            $data['cours_absence'] = $sessions_with_absence;
//            dd($data['cours_absence']);
        }
        $this->renderView('/etudiant/liste_absence', $data);
    }

    public function sendJustification($idEtu,$idSession){
        $errors = $this->validator->validate($_POST,[
           'etudiantJustification' => ["required"],
           'sessionJustification' => ["required"],
           'justificationText' => ["required"]
        ]);

        if ($errors){
            dd($errors);
        }else{
            $this->file->setDir(assets."/justifs");
            $justificationFileName = $this->file->load('fichier');
//            dd($justificationFileName);
            $etudiant = $this->utilisateurModel->getOneEtudiant((int)$_POST['etudiantJustification']);
            $result = $this->justifModel->save([
                'etudiant_id' => $etudiant->id,
                'session_id' => (int)$_POST['sessionJustification'],
                'fichier' => $justificationFileName,
                'texte' => $_POST['justificationText']
            ]);

            if($result){
                $this->redirect("/etu/{$_POST['etudiantJustification']}/absences");
            }
        }
    }

    public function compareDateTimeEndWithNow($datetimeString) {
        $givenDateTime = new \DateTime($datetimeString);
        $currentDateTime = new \DateTime();

        if ($givenDateTime <= $currentDateTime) {
            return true;
        }
        return false;
    }

    public function compareDateTimeWithNow($datetimeString) {
        $givenDateTime = new \DateTime($datetimeString);
        $currentDateTime = new \DateTime();

        if ($givenDateTime < $currentDateTime) {
            return "past";
        } elseif ($givenDateTime == $currentDateTime) {
            return "present";
        } else {
            return "future";
        }
    }

}