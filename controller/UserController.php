<?php

namespace app\controller;

use app\core\BaseController;
use app\models\UserModel;
use app\models\UsersCoursesModel;

class UserController extends BaseController {
    
    public function readOne(): void {
    
        $model = new UserModel();
        $user_id = $_SESSION['user'][0]['user_id'] ?? "NULL";
        $model->one("user_id = $user_id");

        $this->view->render('getUser', 'main', ['user' => $model]);
        
    }

    public function readAll(): void {
        
        
        if (isset($_SESSION['user'][0]['role']) && $_SESSION['user'][0]['role'] === 'Admin') {
                $model = new UserModel();
                $results = $model->all("");
                $this->view->render('getUsers', 'main', $results);
        } else {
            $this->view->render('accessDenied', 'main', null);
        }

    }

    public function updateUser(): void {

        $model = new UserModel();
        $model->mapData($_GET);
        $model->one("user_id = $model->user_id");

        $this->view->render('updateUser', 'main', $model);

    }

    public function processUpdateUser(): void {

        $model = new UserModel();
        $model->mapData($_POST);

        $model->validate();

        if ($model->errors) {
            exit;
        }

        $model->update("WHERE user_id = $model->user_id");
        header("Location: /users");
        exit();
    }

    public function createUser(): void {

        $model = new UserModel();

        $this->view->render('createUser', 'main', $model);

    }  

    public function processCreateUser(): void {
        
        $model = new UserModel();
        $model->mapData($_POST);

        $model->validate();

        if ($model->errors) {
            exit;
        }

        $model->insert();
        header("Location: /users");
        exit();
    }

    public function getUserCourses(): void {
        
    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }

    $userData = $_SESSION['user'][0]; 

    $userId = $userData['user_id'];

    $usersCoursesModel = new UsersCoursesModel();
    $userCourses = $usersCoursesModel->getUserCourses($userId);

    $this->view->render('getUser', 'main', [
        'user' => $userData,
        'courses' => $userCourses
    ]);
    }   
 
    public function enrollCourse(): void {
    header('Content-Type: application/json'); 

    try {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
            exit;
        }

        $userId = $_SESSION['user'][0]['user_id'];
        $courseId = $_POST['course_id'] ?? null;

        if (!$courseId) {
            echo json_encode(['status' => 'error', 'message' => 'No course selected']);
            exit;
        }

        $usersCoursesModel = new UsersCoursesModel();

        if ($usersCoursesModel->isEnrolled($userId, $courseId)) {
            echo json_encode(['status' => 'error', 'message' => 'Already enrolled']);
            exit;
        }

        $usersCoursesModel->enroll($userId, $courseId);

        echo json_encode(['status' => 'success', 'message' => 'You are now enrolled!']);
        exit;

    } catch (\Throwable $e) {
        
        echo json_encode(['status' => 'error', 'message' => 'An internal error occurred']);
        exit;
    }
    }
    
    public function accessRole(): array {
        return ['User', 'Admin'];
    }

}