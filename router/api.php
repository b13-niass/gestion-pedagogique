<?php

use GPD\Core\Routes;
use GPD\App\Controller\ApiController;

$apiRoutes = new Routes();

$apiRoutes->addGetRoute('/api/prof/cours/{id}', ["controller" => ApiController::class, "action" => "listeCoursProf"]);
$apiRoutes->addGetRoute('/dette/list', ["controller" => ApiController::class, "action" => "show"]);

return $apiRoutes;
