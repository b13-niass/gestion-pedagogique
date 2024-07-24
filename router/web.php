<?php

use GPD\App\Controller\ProfesseurController;
use GPD\Core\Routes;
use \GPD\App\Controller\SecurityController;
use \GPD\App\Controller\EtudiantController;

function view($fileName)
{
    require_once '../views/' . $fileName . '.html.php';
}

$webRoutes = new Routes();

$webRoutes->addGetRoute('', ["controller" => SecurityController::class, 'action' => 'login'])->middleware('visitor');
$webRoutes->addGetRoute('/login', ["controller" => SecurityController::class, 'action' => 'login'])->middleware('visitor');
$webRoutes->addGetRoute('/logout', ["controller" => SecurityController::class, 'action' => 'logout'])->middleware('auth');
$webRoutes->addGetRoute('/etu/{idEtu}/cours', ["controller" => EtudiantController::class, 'action' => 'indexCours'])->middleware('auth');
$webRoutes->addGetRoute('/etu/{idEtu}', ["controller" => EtudiantController::class, 'action' => 'index'])->middleware('auth');
$webRoutes->addGetRoute('/prof/{idProf}/accueil', ["controller" => ProfesseurController::class, 'action' => 'indexCalendar'])->middleware('auth');
$webRoutes->addGetRoute('/prof/{idProf}/cours/{idCours}/sessions', ["controller" => ProfesseurController::class, 'action' => 'listeSession'])->middleware('auth');
$webRoutes->addGetRoute('/prof/{idProf}/cours/{idCours}', ["controller" => ProfesseurController::class, 'action' => 'detailsCours'])->middleware('auth');
$webRoutes->addGetRoute('/prof/{idProf}/cours', ["controller" => ProfesseurController::class, 'action' => 'index'])->middleware('auth');
$webRoutes->addGetRoute('/prof/{idProf}', ["controller" => ProfesseurController::class, 'action' => 'index'])->middleware('auth');

// Notion de slug

$webRoutes->addPostRoute('/login', ["controller" => SecurityController::class, 'action' => 'login'])->middleware('visitor');

return $webRoutes;
