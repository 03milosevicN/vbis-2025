<?php

namespace app\models;

use app\core\BaseModel;

class UsersCoursesModel extends BaseModel
{

    public int $users_courses_id;
    public int $users_id;
    public int $courses_id;
    public int $progress = 0;

    public function tableName(): string
    {
        return "users_courses";
    }

    public function readColumns(): array
    {
        return ["users_courses_id", "users_id", "courses_id", "progress"];
    }

    public function editColumns(): array
    {
        return ["users_id", "courses_id", "progress"];
    }

    public function validationRules(): array
    {
        return [];
    }

    public function isEnrolled(int $userId, int $courseId): bool {
        $result = $this->all("WHERE users_id = $userId AND courses_id = $courseId");
        return !empty($result);
    }

    public function enroll(int $userId, int $courseId): void {
        $this->users_id = $userId;
        $this->courses_id = $courseId;
        $this->progress = 0;
        $this->insert();
    }

        public function enrollUserInCourse(int $userId, int $courseId): bool {

        $stmt = $this->connection->prepare("SELECT users_courses_id FROM users_courses WHERE users_id = ? AND courses_id = ?");
        $stmt->bind_param("ii", $userId, $courseId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

    
        $stmt = $this->connection->prepare("INSERT INTO users_courses (users_id, courses_id, progress) VALUES (?, ?, 0)");
        $stmt->bind_param("ii", $userId, $courseId);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function getUserCourses(int $userId): array {
        $sql = "SELECT c.*, uc.progress 
                FROM users_courses uc 
                JOIN courses c ON uc.courses_id = c.courses_id 
                WHERE uc.users_id = $userId";
        $DBResult = $this->connection->query($sql);
        $results = [];
        while ($row = $DBResult->fetch_object()) {
            $results[] = $row;
        }
        return $results;
    }

}