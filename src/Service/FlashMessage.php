<?php

namespace App\Service;

use App\Session\SessionInterface;

class FlashMessage
{

    /**
     * @var SessionInterface
     */
    private $session;

    private $sessionKey = 'flash';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $this->session->delete($this->sessionKey);
        if (array_key_exists($type, $flash)) {
            return $flash[$type];
        }
        return null;
    }
}
