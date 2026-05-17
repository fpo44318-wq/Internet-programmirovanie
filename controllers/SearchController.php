<?php

require_once "BaseSpaceTwigController.php";


class SearchController extends BaseSpaceTwigController {
    public $template = "search.twig";
    public $title = "Поиск";

    public function getContext(): array {
        $context = parent::getContext();
        
        // Получаем параметры поиска
        $search = $_GET['search'] ?? '';
        $type = $_GET['type'] ?? '';
        $title = $_GET['title'] ?? '';
        
        $context['search'] = $search;
        $context['objects'] = [];
        
        if (!empty($search)) {
            // Поиск по полю title
            $sql = "SELECT id, title, description, image FROM space_objects WHERE title LIKE :search";
            $query = $this->pdo->prepare($sql);
            $query->bindValue(":search", "%" . $search . "%");
            $query->execute();
            $context['objects'] = $query->fetchAll();
        }
        
        return $context;
    }
}