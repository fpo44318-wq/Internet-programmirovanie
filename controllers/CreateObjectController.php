<?php

class CreateObjectController extends BaseSpaceTwigController  {
    public $template = "create_object.twig";
    public $title = "Добавить карточку";
    
    public function getContext(): array {
        AuthHelper::requireLogin();
        
        $context = parent::getContext();
        $messages = AuthHelper::getMessages();
        $context['success_message'] = $messages['success'];
        $context['form_errors'] = $messages['errors'];
        $context['old_data'] = $messages['old_data'];
        $context['session'] = AuthHelper::getCurrentUser();
        
        return $context;
    }
    
    public function post(array $context) {
        AuthHelper::requireLogin();
        
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = $_POST['image'] ?? '';
        
        $errors = [];
        if (empty($title)) $errors[] = "Название обязательно";
        if (empty($description)) $errors[] = "Описание обязательно";
        if (empty($image)) $errors[] = "URL картинки обязателен";
        
        if (!empty($errors)) {
            AuthHelper::startSession();
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header("Location: /create");
            exit;
        }
        
        $query = $this->pdo->prepare("
            INSERT INTO space_objects (title, description, image, created_by) 
            VALUES (:title, :description, :image, :user_id)
        ");
        
        $query->execute([
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'user_id' => $_SESSION['user_id']
        ]);
        
        AuthHelper::startSession();
        $_SESSION['success_message'] = "Карточка успешно добавлена!";
        header("Location: /cards");
        exit;
    }
}