<?php

class LogoutController extends BaseController {
    
    // ИСПРАВЛЕНО: добавлен параметр array $context
    public function get(array $context) {
        session_start();
        session_destroy();
        header("Location: /");
        exit;
    }
}