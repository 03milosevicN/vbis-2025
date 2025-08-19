<?php

namespace app\models;

use app\core\BaseModel;
use app\core\Application;

class ReportsModel extends BaseModel {

    //? No database readings.
    public function tableName(): string {
        return '';
    }
    public function readColumns(): array {
        return [];
    }
    public function editColumns(): array {
        return [];
    }
    public function validationRules(): array {
        return [];
    }

    
    public function getUsersPerCourse(): void {
        
        $user_id = 0;
        $sessions = Application::$application->session->get('user');

        foreach ($sessions as $session) {
            $user_id = $session['user_id'];
        }

        $DBresult = $this->connection->query(
            "SELECT c.courses_id, c.title, COUNT(uc.users_id) AS number_of_users
                    FROM courses c
                    LEFT JOIN users_courses uc ON c.courses_id = uc.courses_id
                    GROUP BY c.courses_id, c.title;"
        );

        $resultArray = [];

        while ($result = $DBresult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        echo json_encode($resultArray);

    }

    public function getAverageProgressPerCourse(): void {
        
        $user_id = 0;
        $sessions = Application::$application->session->get('user');

        foreach ($sessions as $session) {
            $user_id = $session['user_id'];
        } 

        $DBresult = $this->connection->query(
            "SELECT c.courses_id, c.title, AVG(uc.progress) AS average_progress
                    FROM courses c
                    LEFT JOIN users_courses uc ON c.courses_id = uc.courses_id
                    GROUP BY c.courses_id, c.title;"
        );

        $resultArray = [];

        while ($result = $DBresult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        echo json_encode($resultArray);
    }

}