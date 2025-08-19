<?php

namespace app\core;

class RenderView {


    public function render($view, $layout, $params) {
        $layout = $this->renderLayout($layout);
        $view = $this->renderPartialView($view, $params);

        echo str_replace("{{ RENDER_SECTION }}", $view, $layout);
    }

    public function renderLayout($layout) {
        ob_start();
        include_once __DIR__ . "/../views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderPartialView($view, $params) {
        if ($params !== null) {
            foreach($params as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include_once __DIR__ . "/../views/$view.php";    
        return ob_get_clean();
    }


}