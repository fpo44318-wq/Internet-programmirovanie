<?php

require_once "BaseSpaceTwigController.php";

class ObjectController extends BaseSpaceTwigController {
    public $template = "object.twig";
    
    public function getContext(): array {
        $context = parent::getContext();
        $context['session'] = AuthHelper::getCurrentUser();

        // Пробуем все возможные варианты получения ID
        $id = 1; // значение по умолчанию
        
        if (isset($this->params['id'])) {
            $id = $this->params['id'];
        } elseif (isset($this->params[0])) {
            $id = $this->params[0];
        } elseif (isset($this->params[1])) {  
            $id = $this->params[1];          
        } 
        
        // Запрос к БД
        $query = $this->pdo->prepare("SELECT id, title, description, info, image FROM space_objects WHERE id = :my_id");
        $query->bindValue(":my_id", $id);
        $query->execute();
        $object = $query->fetch();
        
       
        
        if ($object) {
            $context['object'] = $object;
            $this->title = $object['title'];
            
            $url = $_SERVER["REQUEST_URI"];
            $context['is_image'] = strpos($url, '/image') !== false;
            $context['is_info'] = strpos($url, '/info') !== false;
            $context['url_title'] = 'space-object/' . $id;
        }
        
        return $context;
    }
}