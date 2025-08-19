<?php

namespace app\core;
abstract class BaseController {

    public RenderView $view;

    abstract public function accessRole();

    public function __construct() {

        $this->view = new RenderView();

        $controllerRoles = $this->accessRole();

        $sessionUserData = Application::$application->session->get('user') ?: [];

        
        if ($controllerRoles == []) {
            return;
        }

        $hasAccess = false;

        foreach($sessionUserData as $userData) {
            $userRole = $userData['role'];
            foreach ($controllerRoles as $controllerRole) {
                if ($userRole == $controllerRole) {
                    $hasAccess = true;
                }
        }

        if ($hasAccess) {
            return;
        } else {
            header("location:" . "/accessDenied");
        }

        }
    }
}