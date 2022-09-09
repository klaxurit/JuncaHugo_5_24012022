<?php

namespace App\Core;

use Twig\Environment;
use App\Session\PHPSession;
use App\Twig\FlashExtension;
use App\Managers\UserManager;
use App\Service\FlashMessage;
use App\Managers\AdminManager;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\String\StringExtension;

class Controller
{
    protected string $action;
    protected array $params;
    protected $loader;
    protected $twig;
    protected $session;
    protected $flash;

    public function __construct(string $action, array $params = [])
    {
        $this->session = new PHPSession();
        $this->flash = new FlashMessage($this->session);
        $this->action = $action;
        $this->params = $params;
        $this->loader = new FilesystemLoader(ROOT_DIR . '/templates');
        $this->twig = new Environment($this->loader, [
            'debug' => true,
        ]);
        $this->twig->addExtension(new StringExtension());
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $flashMessage = new FlashMessage($this->session);
        $this->twig->addExtension(new FlashExtension($flashMessage));
        $this->setGlobals();
    }

    /**
     * setGlobals
     *
     * @return void
     */
    public function setGlobals()
    {
        $this->twig->addGlobal("uri", $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/");
        if (null !== $this->session->get("user")) {
            $currentUser = $this->session->get("user");
            $user = (new UserManager())->findOneUser($currentUser->getId());
            $this->twig->addGlobal("user", $currentUser);
        }
        $this->twig->addGlobal("_post", $_POST);
        $admin = (new AdminManager())->findAdmin();

        if (null !== $this->session->get("user") && ($user->getId()) === $admin->getUserId()) {
            // is admin
            $this->twig->addGlobal("adminAccess", $this->session->get("user"));
        }
    }

    /**
     * execute
     *
     * @return void
     */
    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }
}
