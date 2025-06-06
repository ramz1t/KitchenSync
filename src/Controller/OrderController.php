<?php
require_once __DIR__ . '/../Utils.php';

class OrderController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleForm();
            return;
        }

        $restaurant = requireRestaurant($this->pdo);
        $restaurantName = $restaurant['name'];
        require __DIR__ . '/../View/Order/index.php';
    }

    public function handleForm()
    {
        $this->pdo->beginTransaction();

        try {
            // here goes order creation
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            header('Location: /order?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}
