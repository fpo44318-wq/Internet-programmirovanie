<?php
require_once "BaseSpaceTwigController.php";

class SpaceObjectCreateController extends BaseSpaceTwigController {
    public $template = "space_object_create.twig";

    public function get(array $context) {
        echo $_SERVER['REQUEST_METHOD'];
        parent::get($context);
    }

    public function post(array $context) {
        $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $type = $_POST['type'] ?? 'изобретатель';
    $info = $_POST['info'] ?? '';

    $image_url = '';
    if (empty($title)) {
            $errors[] = "Название обязательно для заполнения";
        }
        
        if (empty($description)) {
            $errors[] = "Краткое описание обязательно для заполнения";
        }
        
        if (empty($info)) {
            $errors[] = "Полное описание обязательно для заполнения";
        }
        
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $media_dir = "D:/WEB 2.0/Views/php/media/";
        
        // Проверяем и создаем папку
        if (!is_dir($media_dir)) {
            mkdir($media_dir, 0777, true);
            echo "Папка media создана: " . $media_dir . "<br>";
        }
        
        echo "Папка media существует: " . (is_dir($media_dir) ? 'да' : 'нет') . "<br>";
        echo "Путь: " . $media_dir . "<br>";
        
        $unique_name = time() . '_' . $name;
        $destination = $media_dir . $unique_name;
        echo "Сохраняем в: " . $destination . "<br>";
        
        if (move_uploaded_file($tmp_name, $destination)) {
            $image_url = "/media/" . $unique_name;
            echo "Файл успешно загружен!<br>";
            
            if (file_exists($destination)) {
                echo "Файл существует на диске!<br>";
            }
        } else {
            echo "Ошибка при перемещении файла!<br>";
        }
    } else {
        echo "Файл не загружен или ошибка: " . ($_FILES['image']['error'] ?? 'нет файла') . "<br>";
    }


        if ($image_url) {
            $sql = "INSERT INTO space_objects (title, description, type, info, image) 
                    VALUES (:title, :description, :type, :info, :image_url)";
            
            $query = $this->pdo->prepare($sql);
            $query->bindValue(":title", $title);
            $query->bindValue(":description", $description);
            $query->bindValue(":type", $type);
            $query->bindValue(":info", $info);
            $query->bindValue(":image_url", $image_url);
            $query->execute();
            
            $context['message'] = 'Вы успешно создали объект';
            $context['id'] = $this->pdo->lastInsertId();
        } else {
            $context['message'] = 'Ошибка: не удалось загрузить изображение';
        }

        $this->get($context);
    }
}