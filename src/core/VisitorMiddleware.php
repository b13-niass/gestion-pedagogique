<?php

namespace GPD\Core;

use GPD\App\App;
use GPD\Core\Impl\IMiddleware;
use GPD\Core\Impl\ISession;

class VisitorMiddleware implements IMiddleware
{
    private ISession $session;

    public function __construct(ISession $session){
        $this->session = $session;
    }
    public function handle()
    {
        if (!$this->session->issetE('userConnected')) {
            return true;
        }else{
            $user = $this->session->restoreObjectFromSession('Utilisateur', 'userConnected');
            if ($user->role == 'professeur'){
                header("Location: /prof/{$user->id}");
            }else if ($user->role == 'rps'){
                header("Location: /rps/{$user->id}");
            }else if ($user->role == 'etudiant'){
                header("Location: /etu/{$user->id}");
            }else if ($user->role == 'attache'){
                header("Location: /attache/{$user->id}");
            }
            exit;
        }
    }
}
