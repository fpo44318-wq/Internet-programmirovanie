<?php
require_once "FactsController.php";    // НАСЛЕДУЕТСЯ

class FactsInfoController extends FactsController {
    public $template = "facts_info.twig";

    public function getContext(): array {
    $context = parent::getContext(); // тут придет контекст

    // и мы добавим ему еще пару ключей
    return $context;
    }
}