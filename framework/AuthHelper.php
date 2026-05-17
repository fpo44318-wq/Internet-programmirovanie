<?php

class AuthHelper {
    
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }
    
    public static function isAdmin() {
        self::startSession();
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    public static function getCurrentUser() {
        self::startSession();
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['role'] ?? 'guest'
        ];
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            $_SESSION['login_error'] = "Для этого действия необходимо авторизоваться";
            header("Location: /login");
            exit;
        }
    }
    
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            $_SESSION['login_error'] = "Доступ только для администратора";
            header("Location: /login");
            exit;
        }
    }
    
    public static function getMessages() {
        self::startSession();
        $messages = [
            'success' => $_SESSION['success_message'] ?? null,
            'errors' => $_SESSION['form_errors'] ?? [],
            'old_data' => $_SESSION['old_data'] ?? [],
            'login_error' => $_SESSION['login_error'] ?? null
        ];
        
        unset($_SESSION['success_message']);
        unset($_SESSION['form_errors']);
        unset($_SESSION['old_data']);
        unset($_SESSION['login_error']);
        
        return $messages;
    }
}