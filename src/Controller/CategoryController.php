<?php
require_once __DIR__ . '/../Model/CategoryModel.php';
require_once __DIR__ . '/../Services.php';

class CategoryController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $restaurant = requireRestaurant($this->pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost($restaurant['pk']);
            return;
        }

        $categories = CategoryModel::getAllCategories($this->pdo, $restaurant['pk']);
        $breadcrumbs = [
            ['Home', '/'],
            ['Restaurant', '/restaurant'],
            ['Settings', '/restaurant/settings'],
            ['Categories', '']
        ];

        require __DIR__ . '/../View/Settings/Categories/list.php';
    }

    private function handlePost($restaurantPk)
    {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'create':
                $this->create($restaurantPk);
                break;
            case 'delete':
                $this->delete($restaurantPk);
                break;
            default:
                http_response_code(400);
                exit("Invalid action");
        }
    }

    private function create($restaurantPk)
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            http_response_code(400);
            exit("Category name cannot be empty");
        }

        CategoryModel::createCategory($this->pdo, $restaurantPk, $name, 0);
        header('Location: /restaurant/settings/categories');
        exit;
    }

    private function delete($restaurantPk)
    {
        $pk = $_POST['pk'] ?? null;
        if (!$pk) {
            http_response_code(400);
            exit("No primary key provided");
        }

        verifyCategoryOwnership($this->pdo, $restaurantPk, $pk);
        CategoryModel::deleteCategory($this->pdo, $pk);

        header('Location: /restaurant/settings/categories');
        exit;
    }

    public function edit()
    {
        $restaurantPk = requireRestaurant($this->pdo)['pk'];
        $categoryPk = $_GET['pk'] ?? null;

        if (!$categoryPk) {
            http_response_code(400);
            exit("No primary key provided");
        }

        verifyCategoryOwnership($this->pdo, $restaurantPk, $categoryPk);
        $category = CategoryModel::getCategoryById($this->pdo, $categoryPk);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($categoryPk);
            header('Location: /restaurant/settings/categories');
            exit;
        }

        $breadcrumbs = [
            ['Home', '/'],
            ['Restaurant', '/restaurant'],
            ['Settings', '/restaurant/settings'],
            ['Categories', '/restaurant/settings/categories'],
            ["Edit #$categoryPk", '']
        ];

        require __DIR__ . '/../View/Settings/Categories/edit.php';
    }

    private function update($categoryPk)
    {
        $name = trim($_POST['name'] ?? '');
        $position = $_POST['position'] ?? 0;

        if ($name === '') {
            http_response_code(400);
            exit("Category name cannot be empty");
        }

        CategoryModel::updateCategory($this->pdo, $categoryPk, $name, $position);
    }
}
