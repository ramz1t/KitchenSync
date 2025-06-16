<?php
require_once __DIR__ . '/../Utils.php';

class SettingsController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $restaurant = requireRestaurant($this->pdo);

        $breadcrumbs = [
            ['Home', '/'],
            ['Restaurant', '/restaurant'],
            ['Settings', '']
        ];

        require __DIR__ . '/../View/Settings/index.php';
    }
}
