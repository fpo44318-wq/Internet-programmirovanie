<?php
//require_once "TwigBaseController.php";

class CardsController extends TwigBaseController {
    public $title = "Карточки";
    public $template = "cards.twig";

    public function getContext(): array {
        $context = parent::getContext();
        $context['session'] = AuthHelper::getCurrentUser();
        $query = $this->pdo->query("SELECT * FROM space_objects");
        $context['space_objects'] = $query->fetchAll();        

        $messages = AuthHelper::getMessages();
        $context['success_message'] = $messages['success'];

    return $context;
    }
}