<?php    
//echo "URL: " . $_SERVER["REQUEST_URI"] . "<br>";
require_once 'vendor/autoload.php';
require_once "framework/autoload.php";
require_once 'controllers/MainController.php';
require_once "controllers/ObjectController.php";
require_once "controllers/CardsController.php";
//require_once "controllers/CardsImageController.php";
//require_once "controllers/CardsInfoController.php"; 
require_once "controllers/FactsController.php";
//require_once "controllers/FactsImageController.php";
//require_once "controllers/FactsInfoController.php"; 
require_once "controllers/LoginController.php";
require_once "controllers/LogoutController.php";
require_once "controllers/CreateObjectController.php";
require_once "controllers/DeleteObjectController.php";
require_once "controllers/Controller404.php"; 
require_once "framework/AuthHelper.php";
require_once 'controllers/SearchController.php';
require_once 'controllers/SpaceObjectCreateController.php';
require_once 'controllers/SpaceObjectUpdateController.php';

//require_once 'controllers/BaseController.php';
//require_once 'controllers/TwigBaseController.php';
session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');

$twig = new \Twig\Environment($loader, [
    "debug" => true  
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); 

//$url = $_SERVER["REQUEST_URI"]; 

   // $title = "";
   // $template = "";
    //$context = [];
    //$controller = new Controller404($twig);
    //$query = $pdo->query("SELECT DISTINCT type FROM space_objects ORDER BY 1");
    //$types = $query->fetchAll();
    //$twig->addGlobal("types", $types);
    $pdo = new PDO("mysql:host=localhost;dbname=outer_space;charset=utf8", "root", "1234");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

   $router = new Router($twig, $pdo);
    $router->add("/", MainController::class);
    $router->add("/facts", FactsController::class);
    $router->add("/cards", CardsController::class);
    $router->add("/login", LoginController::class);
    $router->add("/logout", LogoutController::class);
    $router->add("/create", CreateObjectController::class);
    $router->add("/delete/(\d+)", DeleteObjectController::class);
    $router->add("/cards/(?P<id>\d+)/image", ObjectController::class);
    $router->add("/cards/(?P<id>\d+)/info", ObjectController::class);
    $router->add("/space-object/(?P<id>\d+)", ObjectController::class); 
    $router->add("/space-object/(?P<id>\d+)/image", ObjectController::class);
    $router->add("/space-object/(?P<id>\d+)/info", ObjectController::class);
    $router->add("/space-object/create", SpaceObjectCreateController::class);
    $router->add("/search", SearchController::class);
    $router->add("/space-object/(?P<id>\d+)/delete", SpaceObjectDeleteController::class);
    $router->add("/space-object/(?P<id>\d+)/edit", SpaceObjectUpdateController::class);
    //$router->add("/cards/(\d+)/image", ObjectController::class);
   // $router->add("/cards/(\d+)/info", ObjectController::class);
    
    $router->get_or_default(Controller404::class);
   
 //<?php echo "Вы на странице: $url, будьте внимательны!<br>";
    /*if ($url == "/") {
    $controller = new MainController($twig); 

    } elseif (preg_match("#^/login#", $url)) { 
    $title = "Авторизация";
    $template = "login.twig";
    
    }elseif (preg_match("#^/facts/image#", $url)) {
    $controller = new FactsImageController($twig);

    } elseif (preg_match("#^/facts/info#", $url)) {
    $controller = new FactsInfoController($twig);
    
    } elseif (preg_match("#^/facts#", $url)) { 
    $controller = new FactsController($twig);
    
    }elseif (preg_match("#^/cards/image#", $url)) {
    $controller = new CardsImageController($twig);

    } elseif (preg_match("#^/cards/info#", $url)) {
    $controller = new CardsInfoController($twig);

    } elseif (preg_match("#^/cards#", $url)) { 
    $controller = new CardsController($twig);

    }

    if ($controller) {
    $controller->setPDO($pdo); // а тут передаем PDO в контроллер
    $controller->get();*/
//}

    
  

    ?>

    





