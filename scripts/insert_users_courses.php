<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

$mysqli = new mysqli("localhost", "root", "", "vbis-db");

if ($mysqli->connect_errno) {
    die("Failed to connect: " . $mysqli->connect_error);
}

$faker = Faker\Factory::create();


$userIds = [];
$result = $mysqli->query("SELECT user_id FROM users");
while ($row = $result->fetch_assoc()) {
    $userIds[] = $row['user_id'];
}


$courseIds = [];
$result = $mysqli->query("SELECT courses_id FROM courses");
while ($row = $result->fetch_assoc()) {
    $courseIds[] = $row['courses_id'];
}


foreach ($userIds as $userId) {

    
    $numCourses = rand(1, count($courseIds));
    $assignedCourses = $faker->randomElements($courseIds, $numCourses);

    foreach ($assignedCourses as $courseId) {
        
        $check = $mysqli->prepare(
            "SELECT 1 FROM users_courses WHERE users_id = ? AND courses_id = ?"
        );
        $check->bind_param("ii", $userId, $courseId);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) { 
            $progress = rand(0, 100);

            $stmt = $mysqli->prepare(
                "INSERT INTO users_courses (users_id, courses_id, progress) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("iii", $userId, $courseId, $progress);

            if (!$stmt->execute()) {
                echo "Error inserting user_course for user_id=$userId, course_id=$courseId: " . $stmt->error . "\n";
            }
        }

        $check->close();
    }
}

echo "Dummy data inserted into users_courses successfully.\n";
