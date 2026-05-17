<?php
require_once "BaseSpaceTwigController.php";

class SpaceObjectUpdateController extends BaseSpaceTwigController {
    public $template = "space_object_update.twig";
    public $title = "Редактирование объекта";

    public function get(array $context) {
        // Получаем ID из URL
        $id = $this->params['id'] ?? 0;
        
        // Получаем объект из БД
        $sql = "SELECT * FROM space_objects WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        $object = $query->fetch();
        
        $context['object'] = $object;
        
        parent::get($context);
    }

    public function post(array $context) {
        $id = $this->params['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $type = $_POST['type'] ?? 'изобретатель';
        $info = $_POST['info'] ?? '';

         if (empty($title)) {
            $errors[] = "Название обязательно для заполнения";
        }
        
        if (empty($description)) {
            $errors[] = "Краткое описание обязательно для заполнения";
        }
        
        if (empty($info)) {
            $errors[] = "Полное описание обязательно для заполнения";
        }

        // Обработка изображения
        $image_url = $_POST['image_url'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $media_dir = "D:/WEB 2.0/Views/php/media/";
            
            if (!is_dir($media_dir)) {
                mkdir($media_dir, 0777, true);
            }
            
            $unique_name = time() . '_' . $name;
            $destination = $media_dir . $unique_name;
            
            if (move_uploaded_file($tmp_name, $destination)) {
                $image_url = "/media/" . $unique_name;
            }
        }

        $sql = "UPDATE space_objects 
                SET title = :title, description = :description, type = :type, 
                    info = :info, image = :image_url 
                WHERE id = :id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":title", $title);
        $query->bindValue(":description", $description);
        $query->bindValue(":type", $type);
        $query->bindValue(":info", $info);
        $query->bindValue(":image_url", $image_url);
        $query->bindValue(":id", $id);
        $query->execute();
        
        header("Location: /space-object/" . $id);
        exit;
    }
}