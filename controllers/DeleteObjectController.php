<?php

class DeleteObjectController extends BaseController {
    
    public function get(array $context) {
        AuthHelper::requireAdmin();

        
        
        // Получаем ID из параметров URL
         $id = $this->params['id'] ?? $this->params[0] ?? $this->params[1] ?? 1;
    
    $query = $this->pdo->prepare("DELETE FROM space_objects WHERE id = :id");
    $query->execute(['id' => $id]);
    
    AuthHelper::startSession();
    $_SESSION['success_message'] = "Карточка удалена!";
    header("Location: /cards");
    exit;
    }
}