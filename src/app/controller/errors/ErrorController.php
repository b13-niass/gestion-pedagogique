<?php

namespace GPD\App\Controller\Error;

// use GPD\App\App;
use GPD\Core\Controller;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IPaginator;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class ErrorController extends Controller
{
    private static ?IPaginator $paginatorStatic = null;

    public function __construct(IValidator $validator, ISession $session, IFile $file, IAuthorize $authorize, IPaginator $paginator)
    {
        parent::__construct($validator, $session, $file, $authorize, $paginator);
    }
        // public function notFound()
    // {
    //     header("HTTP/1.0 404 Not Found");
    //     require_once $_ENV['VIEW_DIR'] . '/erreur404.html.php';
    // }

    // public function forbidden()
    // {
    // }

    public function loadView(HttpCode $code)
    {

        $this->layout = "error_layout";

        match ($code) {
            HttpCode::Code404 => $this->renderView('/errors/erreur404'),
            HttpCode::Code403 => $this->renderView('/errors/erreur403')
        };
    }
}
