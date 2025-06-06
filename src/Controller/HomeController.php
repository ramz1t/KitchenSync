<?php

require_once __DIR__ . '/../Model/RestaurantModel.php';

class HomeController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        require __DIR__ . '/../View/Home/index.php';
    }
}
