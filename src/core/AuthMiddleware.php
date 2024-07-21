<?php

namespace GPD\Core;

use GPD\App\App;
use GPD\Core\Impl\IMiddleware;
use GPD\Core\Impl\ISession;

class AuthMiddleware implements IMiddleware
{
    private ISession $session;

    public function __construct(ISession $session){
        $this->session = $session;
    }
    public function handle()
    {
        if ($this->session->issetE('userConnected')) {
            return true;
        }

        header('Location: /login');
        exit;
    }
}
