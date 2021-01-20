<?php


namespace app\core;


class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['to_remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $msg)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'to_remove' => false,
            'value' => $msg,
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['to_remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function set(string $string, $primaryValue)
    {
        if (isset($primaryValue, $string)) {
            $_SESSION[$string] = $primaryValue;
        }
    }

    public function unset($string)
    {
        if (isset($string)) {
            unset($_SESSION[$string]);
        }
    }

    public function get($string)
    {
        if (isset($string, $_SESSION[$string])) {
            return $_SESSION[$string];
        }
    }
}