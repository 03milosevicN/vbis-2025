<?php

namespace app\controller;

use app\core\BaseController;
use app\models\ReportsModel;

class AdminController extends BaseController {

    public function accessPanel(): void {
        $this->view->render('adminPanel', 'admin', null);
    }

    public function getUsersPerCourse() {
     
        $model = new ReportsModel();
        
        return $model->getUsersPerCourse();
    }

    public function getAverageProgressPerCourse() {

        $model = new ReportsModel();

        return $model->getAverageProgressPerCourse();
    }

    public function accessRole(): array {
        return ['Admin'];
    }

}