<?php

namespace app\models;

use app\core\BaseModel;

class RolesModel extends BaseModel {

    public int $roles_id;
    public string $name = "";

    public function tableName(): string {
         return "roles"; 
    }

    public function readColumns(): array {
         return ["roles_id", "name"]; 
    }

    public function editColumns(): array { 
        return ["name"];
    }    
    
    public function validationRules(): array {
        return ["name" => [self::RULE_REQUIRED]];
     }

    
}