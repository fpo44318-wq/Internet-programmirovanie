<?php
//require_once "TwigBaseController.php";

class FactsController extends BaseSpaceTwigController  {
    public $title = "Интересные факты";
    public $template = "facts.twig";

    public function getContext(): array {
    $context = parent::getContext();

    return $context;
    }
}