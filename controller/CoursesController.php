<?php

namespace app\controller;

use app\core\BaseController;
use app\models\CoursesModel;
use app\models\UsersCoursesModel;

class CoursesController extends BaseController {
        
    public function readAll(): void {
        
        $model = new CoursesModel();
        $results = $model->all("");

        $this->view->render('courses', 'course', $results);

    }

    public function goToCourse(int $courses_id): void {
        
        $model = new CoursesModel();

        $model->one("courses_id = $courses_id");

        $this->view->render('courses_detail', 'course', ['courses' => $model]);
    }

    public function enroll(): void {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in.']);
        return;
    }

    $userId = (int)$_SESSION['user'][0]['user_id'];
    $courseId = (int)($_POST['course_id'] ?? 0);

    if ($courseId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid course ID.']);
        return;
    }

    $usersCoursesModel = new UsersCoursesModel();
    $success = $usersCoursesModel->enrollUserInCourse($userId, $courseId);

    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'You are now enrolled in this course!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Enrollment failed or course already enrolled.']);
    }
}

    
    public function accessRole(): array {
        return ['Admin', 'User'];
    }

    
}