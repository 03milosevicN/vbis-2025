<?php

namespace app\controller;

use app\core\BaseController;

class ErrorController extends BaseController {

    public function pageNotFound(): void {
        http_response_code(404);
        $this->view->render('404', 'main', null);
    }

    public function accessRole(): array {
        return []; 
    }

}
