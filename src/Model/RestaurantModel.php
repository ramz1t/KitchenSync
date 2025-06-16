<?php
class RestaurantModel
{
    public static function createRestaurant(PDO $pdo, string $name, string $password): int
    {
        $stmt = $pdo->prepare('INSERT INTO restaurants (name, password) VALUES (:name, :password)');
        $stmt->execute([
            ':name' => $name,
            ':password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function loginRestaurant(PDO $pdo, string $name, string $password): ?int
    {
        $stmt = $pdo->prepare('SELECT pk, password FROM restaurants WHERE name = :name');
        $stmt->execute([':name' => $name]);
        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($restaurant && password_verify($password, $restaurant['password'])) {
            return (int) $restaurant['pk'];
        }

        return null;
    }

    public static function getRestaurantById(PDO $pdo, int $pk): ?array
    {
        $stmt = $pdo->prepare('SELECT * FROM restaurants WHERE pk = :pk');
        $stmt->execute([':pk' => $pk]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}