<?php

namespace app\controller;

use app\core\BaseController;
use app\models\UserModel;
use app\models\CoursesModel;

class HomeController extends BaseController {
    
    public function home(): void {
        $this->view->render('home', 'main', []);
    }
    
    public function readUser(): void {
        $model = new UserModel();
        $user_id = $_SESSION['user'][0]['user_id'] ?? null;

        $model->one("user_id = $user_id");
        $this->view->render('home', 'main', ['user' => $model]);
    }

    public function readCourses(): void {
        
        $model = new CoursesModel();
        $results = $model->all("");

        $this->view->render('home', 'main', $results);
    }

    public function accessRole(): array {
        return ['User', 'Admin'];
    }

}