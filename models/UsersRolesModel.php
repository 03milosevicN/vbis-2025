<?php

namespace app\models;

use app\core\BaseModel;

class UsersRolesModel extends BaseModel {

    public int $users_roles_id;
    public int $users_id;
    public int $roles_id;

    public function tableName(): string {
        return "users_roles"; 
    }

    public function readColumns(): array {
        return ["users_roles_id", "users_id", "roles_id"]; 
    }

    public function editColumns(): array {
        return ["users_id", "roles_id"];
    }
    
    public function validationRules(): array {
        return [
            "users_id" => [self::RULE_REQUIRED],
            "roles_id" => [self::RULE_REQUIRED]
        ];
    }

    
}