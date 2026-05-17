<?php

class LoginController extends TwigBaseController {
    public $template = "login.twig";
    public $title = "Вход в систему";
    
    public function getContext(): array {
        $context = parent::getContext();
        
        if (isset($_SESSION['login_error'])) {
            $context['error'] = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        
        return $context;
    }
    
    public function post(array $context) {
        session_start();
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Получаем пользователя из БД
        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->execute(['username' => $username]);
        $user = $query->fetch();
        
        // Проверяем пароль
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: /");
            exit;
        } else {
            $_SESSION['login_error'] = "Неверное имя пользователя или пароль";
            header("Location: /login");
            exit;
        }
    }
}