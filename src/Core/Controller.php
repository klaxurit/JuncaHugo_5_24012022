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
        $this->twig->addGlobal("session", isset($_SESSION['user']));
        $this->twig->addGlobal("_post", $_POST);
        if (isset($_SESSION['user'])) {
            $admin = (new AdminManager())->findAdmin();
            $this->twig->addGlobal("isAdmin", ($_SESSION['user']['id']) === $admin->getUserId());
        }
    }



    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }
}
