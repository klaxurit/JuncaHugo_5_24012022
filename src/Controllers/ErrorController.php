<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller {

    public function show404() {
        var_dump("404");
    }
}