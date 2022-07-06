<?php

namespace App\Core;

use App\Managers\AdminManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{

    protected string $action;
    protected array $params;
    protected $loader;
    protected $twig;

    public function __construct(string $action, array $params = [])
    {
        $this->action = $action;
        $this->params = $params;
        $this->loader = new FilesystemLoader(ROOT_DIR . '/templates');
        $this->twig = new Environment($this->loader, [
            'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->setGlobals();
    }

    public function setGlobals()
    {
        $this->twig->addGlobal("uri", $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/");
        @session_start();
        if (isset($_SESSION['user'])) {
            $this->twig->addGlobal("user", $_SESSION['user']);
        }
        $this->twig->addGlobal("_post", $_POST);
        $admin = (new AdminManager())->findAdmin();
        if (isset($_SESSION['user']) && ($_SESSION['user']->getId()) === $admin->getUserId()) {
            // is admin
            $this->twig->addGlobal("adminAccess", $_SESSION['user']);
        }
    }



    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }
}
