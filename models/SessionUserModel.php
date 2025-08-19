<?php

namespace app\models;

use app\core\BaseModel;

class SessionUserModel extends BaseModel {

    public int $user_id;
    public string $first_name = "";
    public string $last_name = "";
    public string $email = "";
    public string $role = "";

    public function getSessionData(): array {
        
        $query = "SELECT u.user_id AS user_id, u.first_name, u.last_name, u.email, r.name AS role FROM users_roles ur LEFT JOIN users u ON ur.users_id = u.user_id LEFT JOIN roles r ON ur.roles_id = r.roles_id WHERE u.email = '$this->email'";

        $DBResult = $this->connection->query($query);

        $resultArray = [];

        while ($result = $DBResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        return $resultArray;
    }

    public function tableName(): string {
        return "";
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

}