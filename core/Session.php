<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class Session handles HTTP session-related operations.
 */
class Session
{
    /*A flash memory stores content which should be displayed maximum once.
    We store our flash memory with the FLASH_MEMORY_KEY in the superglobal $_SESSION.
    The flash memory stores key/value pairs.*/
    private const FLASH_MEMORY_KEY = 'flashMemory';

    public function __construct()
    {
        //Start a new session.
        session_start();

        /*The constructor of the Session class is called at the beginning of any HTTP request.
        Everything stored in the flash memory at this point of time, needs to be removed at the
        end of the HTTP request. Therefore it is marked correspondingly.*/
        $flashMemory = $_SESSION[Session::FLASH_MEMORY_KEY] ?? [];
        foreach ($flashMemory as $key => &$content) {
            $content['remove'] = true;
        }
        $_SESSION[Session::FLASH_MEMORY_KEY] = $flashMemory;
    }

    public function __destruct()
    {
        /*The destructor of the Session class is called at the end of any HTTP request.
        Everything which was stored in the flash memory at the beginning of the HTTP request,
        is now removed from the flash memory. */
        $flashMemory = $_SESSION[Session::FLASH_MEMORY_KEY] ?? [];
        foreach ($flashMemory as $key => $content) {
            if ($content['remove'] == true) {
                unset($flashMemory[$key]);
            }
        }
        $_SESSION[Session::FLASH_MEMORY_KEY] = $flashMemory;
    }

    //Write to the flash memory.
    public function setFlashMemory(string $key, $value)
    {
        $_SESSION[Session::FLASH_MEMORY_KEY][$key] = [
            'value' => $value,
            'remove' => false
        ];
    }

    //Read from the flash memory.
    public function getFlashMemory(string $key)
    {
        return $_SESSION[Session::FLASH_MEMORY_KEY][$key]['value'] ?? null;
    }

    //Write to the session.
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    //Read from the session.
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    //Delete from the session.
    public function unset($key)
    {
        unset($_SESSION[$key]);
    }

    //Login the user.
    public function login(int $userId)
    {
        $this->set('userId', $userId);
        session_regenerate_id(true);
    }

    //Logout the user.
    public function logout()
    {
        $this->unset('userId');
        session_destroy();
        session_start();
    }
}
