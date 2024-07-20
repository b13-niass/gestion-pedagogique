<?php

use GPD\App\Controller\ProfesseurController;
use GPD\Core\Routes;
use \GPD\App\Controller\SecurityController;

function view($fileName)
{
    require_once '../views/' . $fileName . '.html.php';
}

$webRoutes = new Routes();

$webRoutes->addGetRoute('', ["controller" => SecurityController::class, 'action' => 'login']);
$webRoutes->addGetRoute('/login', ["controller" => SecurityController::class, 'action' => 'login']);
$webRoutes->addGetRoute('/prof', ["controller" => ProfesseurController::class, 'action' => 'index'])->middleware('auth');

// Notion de slug

$webRoutes->addPostRoute('/login', ["controller" => SecurityController::class, 'action' => 'login']);

return $webRoutes;
