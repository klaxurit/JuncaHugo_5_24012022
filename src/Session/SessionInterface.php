<?php

namespace App\Session;

interface SessionInterface
{
    /**
     * Get information in session
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default);

    /**
     * Set information in session
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * Delete a key in session
     *
     * @param  mixed $key
     */
    public function delete(string $key): void;
}
