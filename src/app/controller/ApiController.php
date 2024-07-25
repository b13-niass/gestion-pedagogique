<?php

namespace GPD\App\Controller;

use GPD\App\App;
use GPD\App\Model\CourModel;
use GPD\App\Model\DemandeannulationModel;
use GPD\App\Model\EtudiantModel;
use GPD\App\Model\PresenceModel;
use GPD\App\Model\ProfesseurModel;
use GPD\App\Model\SessionModel;
use GPD\App\Model\UtilisateurModel;
use GPD\Core\Controller;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IPaginator;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class ApiController extends Controller
{
    private CourModel $courModel;
    private UtilisateurModel $utilisateurModel;
    private ProfesseurModel $professeurModel;
    private DemandeannulationModel $demandeannulationModel;
    private SessionModel $sessionModel;
    private EtudiantModel $etudiantModel;
    private PresenceModel $presenceModel;

    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize,$paginator);
        $this->courModel = App::getInstance()->getModel("Cour");
        $this->utilisateurModel = App::getInstance()->getModel("Utilisateur");
        $this->professeurModel = App::getInstance()->getModel("Professeur");
        $this->demandeannulationModel = App::getInstance()->getModel("Demandeannulation");
        $this->sessionModel = App::getInstance()->getModel("Session");
        $this->etudiantModel = App::getInstance()->getModel("Etudiant");
        $this->presenceModel = App::getInstance()->getModel("Presence");
    }

    public function listeCoursProf($idProf)
    {
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $cours = $this->professeurModel->getCoursByProfesseur($professeur->id);
            $cours = $this->professeurModel->coursWithInfo($cours);

            $cours_for_api = [];
            foreach ($cours as $cour) {
                $cour->classes = $this->convertObjectsToArray($cour->classes);
                $cours_for_api[] = $cour;
            }

            echo json_encode($this->convertObjectsToArray($cours_for_api));
        }else{
            echo json_encode([]);
        }
    }

    public function allSessions($idProf){
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
            $sessions = $this->professeurModel->getProfSessions($cours);
            $sessionsArray = $this->convertObjectsToArray($sessions);
            echo json_encode($this->transformSessions($sessionsArray));
        }else{
            echo json_encode([]);
        }
    }

    public function listeSessionsCour($idProf, $idCours){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            $professeur = $this->utilisateurModel->getOneProfesseur($user->id);
            $courModel = $this->professeurModel->getOneCourByProfesseur($professeur->id, $idCours);
            $sessions = $courModel->getSessions();
            $sessionsArray = $this->convertObjectsToArray($sessions);

            header('Content-Type: application/json');
            echo json_encode($this->transformSessions($sessionsArray));
        }else{
            echo json_encode([]);
        }
    }

    public function annulerSessionsCour($idProf, $idCour)
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        if (isset($data['request_type']) && $data['request_type'] == 'cancelEvent'){
            $idSession = (int)$data['event_id']??'';
            $justification = $data['justification']??'';
            if(!empty($idSession) && !empty($justification)){
                $this->sessionModel->setTable();
                $result =  $this->sessionModel::update([
                    "etat_avancement" => "ATTENTE",
                    "id" => $idSession
                ]);
                if ($result){
                    $this->demandeannulationModel->setTable();
                    $result = $this->demandeannulationModel->save([
                        'session_id' => $idSession,
                        'justification' => $justification,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    if ($result){
                        echo json_encode(['status' => 1]);
                    }else{
                        echo json_encode(['status' => 2]);
                    }
                }
            }
        }
//        echo $postData;
    }

    public function convertObjectsToArray(array $objects)
    {
        if (!is_array($objects)) {
            throw new \InvalidArgumentException("Expected an array of objects.");
        }

        $resultArray = [];

        foreach ($objects as $object) {
            if (!is_object($object)) {
                throw new \InvalidArgumentException("Array elements must be objects.");
            }

            $reflectionClass = new \ReflectionClass($object);
            $properties = $reflectionClass->getProperties();

            $objectData = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $objectData[$property->getName()] = $property->getValue($object);
            }

            $resultArray[] = $objectData;
        }

        return $resultArray;
    }

    public function allEtudiantSessions($idEtu){
        $data = [];
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            if($idEtu!= $user->id){
                $this->redirect("/etu/{$user->id}");
            }
            $etudiant = $this->utilisateurModel->getOneEtudiant($user->id);
            $this->etudiantModel->getEntity()->id = $etudiant->id;
            $data['cours'] = $this->etudiantModel->getCoursByEtudiant($etudiant->classe_id);
            $sessions = $this->etudiantModel->getEtudiantSessions($data['cours']);
            $sessions = $this->etudiantModel->getEtudiantSessionsWithPresence($data['cours']);
            $sessionsArray = $this->convertObjectsToArray($sessions);
            echo json_encode($this->transformEtudiantSessions($sessionsArray));
        }else{
            echo json_encode([]);
        }
    }

    public function allEtudiantAbsence($idEtu)
    {
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
            $data['cours_absence'] = $sessions_with_absence;
            echo json_encode($this->convertObjectsToArray($data['cours_absence']));
        }else{
            echo json_encode([]);
        }
    }

    public function listeCoursEtu($idEtu)
    {
        if($this->session->issetE('userConnected')){
            $data['user'] = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            $user = $data['user'];
            $etudiant = $this->utilisateurModel->getOneEtudiant($user->id);
            $this->etudiantModel->getEntity()->id = $etudiant->id;
            $cours = $this->etudiantModel->getCoursByEtudiant($etudiant->classe_id);
            $cours= $this->etudiantModel->coursWithInfo($cours);

            $cours_for_api = [];
            foreach ($cours as $cour) {
                $cour->classes = $this->convertObjectsToArray($cour->classes);
                $cours_for_api[] = $cour;
            }

            echo json_encode($this->convertObjectsToArray($cours_for_api));
        }else{
            echo json_encode([]);
        }
    }

    public function marquerPresenceEtudiant($idEtu){
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
//        echo json_encode($data);
        if (isset($data['request_type']) && $data['request_type'] == 'togglePresence'){
            $idSession = (int)$data['event_id']??'';
            if(!empty($idSession) && !empty($idEtu)){
                $this->presenceModel->setTable();
                $etudiant = $this->utilisateurModel->getOneEtudiant((int)$idEtu);
                $result = $this->presenceModel->save([
                    'session_id' => (int)$idSession,
                    'etudiant_id' => $etudiant->id
                ]);
                if ($result){
                    echo json_encode(['status' => 1]);
                } else{
                    echo json_encode(['status' => 2]);
                }
            }
        }
    }

    public function transformSessions($sessions) {
        $events = [];

        foreach ($sessions as $session) {
            $events[] = [
                'id' => $session['id'],
                'title' => 'Session de ' . $session['module_name'],
                'start' => str_replace(' ', 'T', $session['heureDebut']),
                'end' => str_replace(' ', 'T', $session['heureFin']),
                'etat_avancement' => $session['etat_avancement'],
                'etat_global' => $session['etat_global']
            ];
        }

        return $events;
    }

    public function transformEtudiantSessions($sessions) {
        $events = [];

        foreach ($sessions as $session) {
            $events[] = [
                'id' => $session['id'],
                'title' => 'Session de ' . $session['module_name'],
                'start' => str_replace(' ', 'T', $session['heureDebut']),
                'end' => str_replace(' ', 'T', $session['heureFin']),
                'etat_presence' => $session['presence'],
                'etat_avancement' => $session['etat_avancement'],
                'etat_global' => $session['etat_global']
            ];
        }

        return $events;
    }

    public function compareDateTimeEndWithNow($datetimeString) {
        $givenDateTime = new \DateTime($datetimeString);
        $currentDateTime = new \DateTime();

        if ($givenDateTime <= $currentDateTime) {
            return true;
        }
        return false;
    }
}
