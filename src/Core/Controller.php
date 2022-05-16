<?php

namespace App\Core;

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
    }

    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }
}
