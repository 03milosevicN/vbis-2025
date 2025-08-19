<?php

namespace app\core;

class Session {

    public function __construct() {
        session_start();
    }


    public function set($key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get($key): mixed {
        return $_SESSION[$key] ?? false;
    }

    public function delete($key): void {
        unset($_SESSION[$key]);
    }

    public function isInRole($role): bool {
        $isInRole = false;

        $sessions = Application::$application->session->get('user');

        foreach($sessions as $session) {
            if ($session['role'] == $role) {
                $isInRole = true;
            }
        }

        return $isInRole;
    }


}