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

    private $message;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * Set information in session
     *
     * @param  mixed $message
     * @param  mixed $type
     * @return void
     */
    public function set(string $message, string $type)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash[$type] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    /**
     * Get information in session
     *
     * @param  mixed $type
     * @return void
     */
    public function get(string $type)
    {
        if (is_null($this->message)) {
            $this->message = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        // Check if key exist
        if (array_key_exists($type, $this->message)) {
            // Return message
            return $this->message[$type];
        }
        return null;
    }
}
