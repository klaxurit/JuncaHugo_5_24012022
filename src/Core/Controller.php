<?php

namespace App\Core;

class Controller {

    protected string $action;

    public function __construct(string $action, array $params = []) {
        $this->action = $action;
    }

    public function execute() {
        $method = $this->action;
        $this->method;
    }
}