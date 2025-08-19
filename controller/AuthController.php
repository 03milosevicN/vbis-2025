<?php

namespace app\controller;

use app\core\Application;
use app\core\BaseController;
use app\models\RegistrationModel;
use app\models\RolesModel;
use app\models\UsersRolesModel;
use app\models\LoginModel;
use app\models\SessionUserModel;

class AuthController extends BaseController {
    
    public function registration(): void {
        $this->view->render('registration', 'auth', new RegistrationModel());
    }

    public function processRegistration(): void {
        
        $model = new RegistrationModel();
        $model->mapData($_POST);
        $model->validate();

        if ($model->errors) {
            Application::$application->session->set('errorNotification', "Invalid registration attempt.");
            $this->view->render('registration', 'auth', $model);
            exit;
        }
        
        $model->password = password_hash($model->password, PASSWORD_DEFAULT);
        
        $model->insert();
        $model->one("email = '$model->email'" );

        $rolesModel = new RolesModel();
        $rolesModel->one("name = 'User'");

        $usersRolesModel = new UsersRolesModel();
        $usersRolesModel->users_id = $model->user_id;
        $usersRolesModel->roles_id = $rolesModel->roles_id;

        $usersRolesModel->insert();
        
        Application::$application->session->set('successNotification', "Successful registration!");
        header("Location: /login");
        exit();
        
    }


    public function login(): void {
        if (Application::$application->session->get('user')) {
            header("Location: /home");
            exit();
        }
        
        $this->view->render('login', 'auth', new LoginModel());
    }

    public function processLogin(): void {

        $model = new LoginModel();
        $model->mapData($_POST);
        $model->validate();

        if ($model->errors) {
            $this->view->render('login', 'auth', $model);
            exit;
        }

        $loginPassword = $model->password;
        $model->one("email = '$model->email'");

        $verifyResult = password_verify($loginPassword, $model->password);

        if ($verifyResult) {
            $sessionUserModel = new SessionUserModel();
            $sessionUserModel->email = $model->email;

            Application::$application->session->set('user', $sessionUserModel->getSessionData());
            header("Location: /home");
        }

        $model->password = $loginPassword;

        Application::$application->session->set('errorNotification', "Invalid login attempt.");
        $this->view->render('login', 'auth', $model);
    }


    public function processLogout(): void {
        Application::$application->session->delete('user');
        header("Location: /login");
        exit();
    }


    public function accessDenied(): void {
        $this->view->render('accessDenied', 'auth', null);
    }

    
    public function accessRole(): array {
        return ['User', 'Admin'];
    }


}