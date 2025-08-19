<?php

namespace app\core;

class Request {

    public function handlePath(): string {

        $path = $_SERVER['REQUEST_URI'] ?? '/';  
        
        if ( strpos($path, '?') === false ) {
            return $path;
        }

        return substr($path, 0, strpos($path, '?'));
        
    }


    public function handleMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    
}