<?php

use GPD\Core\Routes;
use GPD\App\Controller\ApiController;

$apiRoutes = new Routes();

//$apiRoutes->addGetRoute('/api/dette/list', ["controller" => ApiController::class, "action" => "show"]);
//$apiRoutes->addGetRoute('/dette/list', ["controller" => ApiController::class, "action" => "show"]);

return $apiRoutes;
