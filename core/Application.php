<?php

namespace app\core;


class Application {
    
    public Session $session;
    public Router $router;
    public static Application $application;


    public function __construct() {
        
        $this->router = new Router();
        $this->session = new Session();
        self::$application = $this;
        
    }

    public function run(): void {
        $this->router->resolve();
    }

}