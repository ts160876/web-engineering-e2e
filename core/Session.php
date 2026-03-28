<?php

namespace Bukubuku\Core;

class Session
{

    private const FLASH_MEMORY_KEY = 'flashMemory';


    public function __construct()
    {
        session_start();
        $flashMemory = $_SESSION[Session::FLASH_MEMORY_KEY] ?? [];
        foreach ($flashMemory as $key => &$content) {
            $content['remove'] = true;
        }
        $_SESSION[Session::FLASH_MEMORY_KEY] = $flashMemory;
    }

    public function __destruct()
    {
        $flashMemory = $_SESSION[Session::FLASH_MEMORY_KEY] ?? [];
        foreach ($flashMemory as $key => $content) {
            if ($content['remove'] == true) {
                unset($flashMemory[$key]);
            }
        }
        $_SESSION[Session::FLASH_MEMORY_KEY] = $flashMemory;
    }

    public function setFlashMemory(string $key, $value)
    {
        $_SESSION[Session::FLASH_MEMORY_KEY][$key] = [
            'value' => $value,
            'remove' => false
        ];
    }

    public function getFlashMemory(string $key)
    {
        return $_SESSION[Session::FLASH_MEMORY_KEY][$key]['value'] ?? null;
    }
}
