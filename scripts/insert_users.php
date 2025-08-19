<?php

require_once __DIR__ . "/../vendor/autoload.php";

$mysqli = new mysqli("localhost", "root", '', "vbis-db");

$faker = Faker\Factory::create();

//? Insert into: users
for ($i = 0; $i < 50; $i++) {

    $first = $faker->firstName;
    $last = $faker->lastName;
    $email = $faker->unique()->safeEmail;
    $password = password_hash("123123", PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");    
    $stmt->bind_param("ssss", $first, $last, $email, $password);
    $stmt->execute();

}
echo "Inserted dummy data. \n";
