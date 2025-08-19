<?php

namespace app\core;

use mysqli;

class DBInit {

    public function connect(): mysqli {
        $mysqli = new mysqli("localhost", "root", '', "vbis-db");
        return $mysqli;    
    }

}