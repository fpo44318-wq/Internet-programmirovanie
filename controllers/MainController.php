<?php
require_once "BaseSpaceTwigController.php";

class MainController extends BaseSpaceTwigController {
    public $template = "main.twig";
    public $title = "Главная";
    
    
    public function getContext(): array {
        $context = parent::getContext();
         $context['session'] = AuthHelper::getCurrentUser();
         
        $query = $this->pdo->query("SELECT id, title FROM space_objects");
        
        $context['space_objects'] = $query->fetchAll();

        $context['menu_items'] = [
            [
                "title" => "Карточки",
                "url_title" => "cards"
            ],
            [
                "title" => "Интересные факты",
                "url_title" => "facts"
            ]
        ];
        return $context;
    }
}