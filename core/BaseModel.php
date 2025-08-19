<?php

namespace app\core;

use app\core\DBInit;
use mysqli;

abstract class BaseModel {

    public const RULE_EMAIL = "rule_email";
    public const RULE_REQUIRED = "rule_required";
    public const RULE_UNIQUE_EMAIL = "rule_unique_email";
    public const GREATER_THAN_ZERO = "greater_than_zero";


    public mysqli $connection;
    private DBInit $db;
    public $errors;

    public function __construct() {
        $this->db = new DBInit();
        $this->connection = $this->db->connect();
    }



    abstract public function tableName(): string;
    abstract public function readColumns(): array;
    abstract public function editColumns(): array;
    abstract public function validationRules(): array;


    public function one($condition): void {
        $tableName = $this->tableName();
        $columns = $this->readColumns();

        $sql = "SELECT " . implode(',', $columns) . " FROM $tableName";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $sql .= " LIMIT 1";

        $DBResult = $this->connection->query($sql);
        $result = $DBResult->fetch_assoc();

        if ($result != null) {
            $this->mapData($result);
        }
    }
    
    public function all($where): array { 

        $tableName = $this->tableName();
        $columns = $this->readColumns();
        $result_array = [];
        $DBResult = $this->connection->query("SELECT " . implode(',', $columns) . " FROM $tableName $where" );
        
        while ($result = $DBResult->fetch_assoc()) {
            $result_array[] = $result;
        }

        return $result_array;
     }

    public function update($where): void {
        
        $tableName = $this->tableName();
        $columns = $this->editColumns();
        $columnsHelper = array_map( fn($attr) => ":$attr", $columns );    
        $commonHelper = [];

        for ($i = 0; $i < count($columnsHelper); $i++) {
            $commonHelper[] = "$columns[$i] = $columnsHelper[$i]";
        }

        $query = "UPDATE $tableName SET " . implode(',', $commonHelper) . " $where";

        foreach($columns as $attribute) {
            $query = str_replace(":$attribute", is_string($this->{$attribute}) ? '"' . $this->{$attribute} . '"' : $this->{$attribute}, $query);
        }

        $this->connection->query($query);

    }  

    public function insert(): void {
        $tableName = $this->tableName();
        $columns = $this->editColumns();
        $columnsHelper = array_map(fn($attr) => ":$attr", $columns);

        $query = "INSERT INTO $tableName (" . implode(",", $columns) . ") VALUES (" . implode(",", $columnsHelper) . ")";

        foreach ($columns as $attribute) {
            $query = str_replace(":$attribute", is_string($this->{$attribute}) ? '"' . $this->{$attribute} . '"' : $this->{$attribute}, $query);
        }

        $this->connection->query($query);
    }

    public function mapData($data): void {
        
        if ($data != null) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

    }

    public function validate(): void {

         $allRules = $this->validationRules();

        foreach ($allRules as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                if ($rule == self::RULE_REQUIRED) {
                    if (!$value) {
                        $this->errors[$attribute][] = "This field is required!";
                    }
                }

                if ($rule == self::RULE_EMAIL) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->errors[$attribute][] = "Email must be in Email format!";
                    }
                }

                if ($rule == self::RULE_UNIQUE_EMAIL) {
                    if ($this->checkUniqueEmail($value)) {
                        $this->errors[$attribute][] = "This Email already exists!";
                    }
                }

                if ($rule == self::GREATER_THAN_ZERO) {
                    if ($value <= 0) {
                        $this->errors[$attribute][] = "This field must be greater than 0!";
                    }
                }
            }
        }

    }

    public function checkUniqueEmail($email): bool {
        
        $DBResult = $this->connection->query("SELECT EMAIL FROM USERS WHERE EMAIL = '$email'");
        $result = $DBResult->fetch_assoc();

        if ($result != null) {
            return true;
        }

        return false;
    }

}