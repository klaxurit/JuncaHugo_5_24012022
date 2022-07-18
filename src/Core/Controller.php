<?php

namespace App\Core;

use App\Model\User;
use Twig\Environment;
use App\Session\PHPSession;
use App\Twig\FlashExtension;
use App\Managers\UserManager;
use App\Service\FlashMessage;
use App\Managers\AdminManager;
use App\Session\SessionInterface;
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
        $session = new PHPSession();
        $flashMessage = new FlashMessage($session);
        $this->twig->addExtension(new FlashExtension($flashMessage));
        $this->setGlobals();
    }

    public function setGlobals()
    {
        $this->twig->addGlobal("uri", $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/");
        if (isset($_SESSION['user'])) {
            // $user = new User($_SESSION['user']);
            $userId = (new UserManager())->findOneUser($_SESSION['user']['id']);
            $this->twig->addGlobal("user", $_SESSION['user']);
        }
        $this->twig->addGlobal("_post", $_POST);
        if (isset($_SESSION)) {
            $this->twig->addGlobal("_session", $_SESSION);
        }
        $admin = (new AdminManager())->findAdmin();

        if (isset($_SESSION['user']) && ($userId->getId()) === $admin->getUserId()) {
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
