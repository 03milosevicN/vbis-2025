<?php

namespace app\models;

use app\core\BaseModel;

class CoursesModel extends BaseModel {

    public int $courses_id;
    public string $title = "";
    public string $description = "";
    public int $price;

    public function tableName(): string { 
        return "courses"; 
    }
    
    public function readColumns(): array { 
        return ["courses_id", "title", "description", "price"]; 
    }

    public function editColumns(): array {
        return ["title", "description", "price"];
    }

    public function validationRules(): array {
        return [];
     }


}
