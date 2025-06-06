<?php
require_once __DIR__ . '/../Utils.php';

class RestaurantController
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
        require __DIR__ . '/../View/Restaurant/index.php';
    }

    public function handleForm()
    {
        $action = $_POST['action'] ?? '';
        $name = $_POST['name'] ?? '';
        $pass = $_POST['pass'] ?? '';

        if (empty($name) || empty($pass)) {
            header('Location: /?error=empty_fields');
            exit;
        }

        require_once __DIR__ . '/../Model/RestaurantModel.php';

        if ($action === 'create') {
            $restaurantId = RestaurantModel::createRestaurant($this->pdo, $name, $pass);
            createSignedCookie('restaurant_cookie', $restaurantId);
            header('Location: /restaurant');
            exit;
        } elseif ($action === 'find') {
            $restaurantId = RestaurantModel::loginRestaurant($this->pdo, $name, $pass);
            if ($restaurantId !== null) {
                createSignedCookie('restaurant_id', $restaurantId);
                header('Location: /restaurant');
                exit;
            } else {
                header('Location: /?error=invalid');
                exit;
            }
        } else {
            header('Location: /?error=invalid_action');
            exit;
        }
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            setcookie('restaurant_id', '', time() - 3600, '/');
        }
        header('Location: /');
        exit;
    }
}
