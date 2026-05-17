<?php

class BaseSpaceTwigController extends TwigBaseController {
    public function getContext(): array
    {
    $context = parent::getContext();

    $query = $this->pdo->query("SELECT DISTINCT type FROM space_objects ORDER BY 1");
    $types = $query->fetchAll();
    $context['types'] = $types;
    $user = AuthHelper::getCurrentUser();
        $context['session'] = [
            'user_id' => $user['id'],      
            'username' => $user['username'],
            'role' => $user['role']
        ];

    return $context;
    }
    
}