<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    protected string $action;
    protected array $params;
    protected $loader;
    protected $twig;

    public function __construct(string $action, array $params = []) {
        $this->action = $action;
        $this->params = $params;
        $this->loader = new FilesystemLoader(ROOT_DIR.'/templates');
        $this->twig = new Environment($this->loader);
    }

    public function execute() {
        $method = $this->action;
        $this->$method();
    }




}