<?php

namespace App\Core;

class Controller {

    protected string $action;
    protected array $params;

    public function __construct(string $action, array $params = []) {
        $this->action = $action;
        $this->params = $params;
    }

    public function execute() {
        $method = $this->action;
        $this->$method();
    }


}