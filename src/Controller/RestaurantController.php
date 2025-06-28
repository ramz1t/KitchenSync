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

    public function settings()
    {
        $restaurant = requireRestaurant($this->pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSettingsPost($restaurant['pk']);
            $restaurant = requireRestaurant($this->pdo);
        }

        $breadcrumbs = [
            ['Home', '/'],
            ['Restaurant', '/restaurant'],
            ['Settings', '/restaurant/settings'],
            ['Edit restaurant', ''],
        ];

        require __DIR__ . '/../View/Settings/Restaurant/edit.php';
    }

    private function handleSettingsPost($restaurantPk)
    {
        require_once __DIR__ . '/../Model/RestaurantModel.php';
        require_once __DIR__ . '/../Utils.php';

        $restaurant = requireRestaurant($this->pdo);
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'update':
                $this->updateRestaurant($restaurant);
                break;
            case 'change-password':
                $this->changePassword($restaurant);
                break;
            case 'delete':
                $this->deleteRestaurant($restaurant);
                break;
            default:
                http_response_code(400);
                exit("Invalid action - \"" . $action . "\"");
        }
    }

    private function updateRestaurant($restaurant)
    {
        $name = trim($_POST['name'] ?? '');
        $currency = trim($_POST['currency'] ?? '');

        if (empty($name) || empty($currency)) {
            http_response_code(400);
            exit('Fields can\'t be empty');
        }

        RestaurantModel::updateRestaurantById($this->pdo, $restaurant['pk'], $name, $currency);
    }

    private function changePassword($restaurant)
    {
    }

    private function deleteRestaurant($restaurant)
    {
        $pass = $_POST['password'] ?? "";
        if (!password_verify($pass, $restaurant['password'])) {
            http_response_code(403);
            header('Location: ?error=wrong-pass');
            exit;
        }

        // RestaurantModel::deleteRestaurant($this->pdo, $restaurant['pk']);

        setcookie("restaurant_pk", null);
        header('Location: /?success=deleted');
        exit;
    }
}
