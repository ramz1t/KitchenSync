<?php
function verifyCategoryOwnership(PDO $pdo, int $restaurantPk, int $categoryPk)
{
    $category = CategoryModel::getCategoryById($pdo, $categoryPk);
    if (!$category || $category['restaurant_pk'] !== $restaurantPk) {
        http_response_code(403);
        exit("You do not have permission to access this category");
    }
}