<?php
function requireRestaurant(PDO $pdo): array
{
    if (isset($_COOKIE['restaurant_id'])) {
        $restaurantId = $_COOKIE['restaurant_id'];
        $restaurant = RestaurantModel::getRestaurantById($pdo, $restaurantId);
        if ($restaurant) {
            return $restaurant;
        }
    }
    header('Location: /?error=session_expired');
    exit;
}
