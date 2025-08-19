<?php

require_once __DIR__ . "/../vendor/autoload.php";

use app\controller\UserController;
use app\controller\HomeController;
use app\controller\CoursesController;
use app\controller\AuthController;
use app\controller\AdminController;
use app\controller\ErrorController;
use app\core\Application;


$application = new Application();

//? Home:
$application->router->get("/", [HomeController::class, 'home']);
$application->router->get("/home", [HomeController::class, 'home']);
$application->router->get("/home", [HomeController::class, 'readCourses']);


//? Users: 
$application->router->get("/getUser", [UserController::class, 'readOne']);
$application->router->get("/getUser", [UserController::class, 'getUserCourses']);
$application->router->get("/getUsers", [UserController::class, 'readAll']);
$application->router->get("/processLogout", [UserController::class, 'processLogout']);
$application->router->get("/accessDenied", [AuthController::class, 'accessDenied']);

//? Courses:
$application->router->get("/courses", [CoursesController::class, 'readAll']);
$application->router->get("/courses/{course_id}", [CoursesController::class, 'goToCourse']);
$application->router->post("/courses/enroll", [UserController::class, 'enrollCourse']);


//? Authentication:
$application->router->get("/registration", [AuthController::class, 'registration']);
$application->router->post("/processRegistration", [AuthController::class, 'processRegistration']);
$application->router->get("/login", [AuthController::class, 'login']);
$application->router->get("/processLogout", [AuthController::class, 'processLogout']);
$application->router->get("/accessDenied", [AuthController::class, 'accessDenied']);
$application->router->post("/processLogin", [AuthController::class, 'processLogin']);

//? Admin:
$application->router->get("/adminPanel", [AdminController::class, 'accessPanel']);
$application->router->get("/adminPanel/getUsersPerCourse", [AdminController::class, 'getUsersPerCourse']); 
$application->router->get("/adminPanel/getAverageProgressPerCourse", [AdminController::class, 'getAverageProgressPerCourse']);

$application->router->notFound([ErrorController::class, 'pageNotFound']);

$application->run();