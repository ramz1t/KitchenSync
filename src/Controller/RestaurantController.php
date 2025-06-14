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

        $breadcrumbs = [
            ['Home', '/'],
            ['Restaurant', ''],
        ];

        require __DIR__ . '/../View/Restaurant/index.php';
    }

    public function handleForm()
    {
        $action = $_POST['action'] ?? '';
        $name = $_POST['name'] ?? '';
        $pass = $_POST['pass'] ?? '';

        if (empty($name) || empty($pass)) {
            $this->redirectWithError('empty_fields');
        }

        require_once __DIR__ . '/../Model/RestaurantModel.php';

        try {
            $restaurantId = $this->processRestaurantAction($action, $name, $pass);
            $this->handleSuccess($restaurantId);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $this->redirectWithError('duplicate_name');
            } else {
                $this->redirectWithError('creation_failed');
            }
        } catch (Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    private function processRestaurantAction($action, $name, $pass)
    {
        switch ($action) {
            case 'create':
                return RestaurantModel::createRestaurant($this->pdo, $name, $pass);
            case 'find':
                $restaurantId = RestaurantModel::loginRestaurant($this->pdo, $name, $pass);
                if ($restaurantId === null) {
                    throw new Exception('invalid');
                }
                return $restaurantId;
            default:
                throw new Exception('invalid_action');
        }
    }

    private function handleSuccess($restaurantId)
    {
        createSignedCookie('restaurant_pk', $restaurantId);
        $redirectUrl = $_GET['redirect'] ?? '/restaurant';
        header('Location: ' . $redirectUrl);
        exit;
    }

    private function redirectWithError($error)
    {
        header('Location: /?error=' . $error);
        exit;
    }

}
