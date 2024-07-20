<?php

namespace GPD\Core;

use GPD\App\App;
use GPD\Core\Impl\IMiddleware;

class AuthMiddleware implements IMiddleware
{
    public function handle()
    {
//        $session = App::getInstance()->getContainer()->get(Session::class);
//        if ($session->isLoggedIn()) {
            return true;
//        }
//
//        header('Location: /login');
//        exit;
    }
}
