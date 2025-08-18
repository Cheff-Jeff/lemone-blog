<?php

namespace PHP\Helpers;

class SessionController
{
    public static function startSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}