<?php

use GPD\Core\Routes;
use GPD\App\Controller\ApiController;

$apiRoutes = new Routes();

$apiRoutes->addGetRoute('/api/prof/{idProf}/cours/{idCours}/sessions', ["controller" => ApiController::class, "action" => "listeSessionsCour"])->middleware('auth');
$apiRoutes->addPostRoute('/api/prof/{idProf}/cours/{idCours}/sessions', ["controller" => ApiController::class, "action" => "annulerSessionsCour"])->middleware('auth');
$apiRoutes->addGetRoute('/api/etu/{idEtu}/absences', ["controller" => ApiController::class, 'action' => 'allEtudiantAbsence'])->middleware('auth');
$apiRoutes->addGetRoute('/api/etu/{idEtu}/cours', ["controller" => ApiController::class, 'action' => 'listeCoursEtu'])->middleware('auth');
$apiRoutes->addGetRoute('/api/etu/{idEtu}/sessions', ["controller" => ApiController::class, 'action' => 'allEtudiantSessions'])->middleware('auth');
$apiRoutes->addPostRoute('/api/etu/{idEtu}/sessions', ["controller" => ApiController::class, 'action' => 'marquerPresenceEtudiant'])->middleware('auth');
$apiRoutes->addGetRoute('/api/prof/{idProf}/sessions', ["controller" => ApiController::class, 'action' => 'allSessions'])->middleware('auth');
$apiRoutes->addPostRoute('/api/prof/{idProf}/sessions', ["controller" => ApiController::class, 'action' => 'annulerSessionsCour'])->middleware('auth');
$apiRoutes->addGetRoute('/api/prof/{idProf}/cours', ["controller" => ApiController::class, "action" => "listeCoursProf"])->middleware('auth');

return $apiRoutes;
