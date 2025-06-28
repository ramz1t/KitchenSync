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

    public static function updateRestaurantById(PDO $pdo, int $pk, string $name, string $currency): bool
    {
        $stmt = $pdo->prepare('UPDATE restaurants SET name=:name, currency=:currency WHERE pk=:pk');
        return $stmt->execute([':pk' => $pk, ':name' => $name, ':currency' => $currency]);
    }

    public static function deleteRestaurant(PDO $pdo, int $pk): bool
    {
        $stmt = $pdo->prepare('DELETE FROM restaurants WHERE pk=:pk');
        return $stmt->execute([':pk' => $pk]);
    }

    public static function changePassword(PDO $pdo, int $pk, string $password): bool
    {
        $stmt = $pdo->prepare('UPDATE restaurants SET password=:password WHERE pk=:pk');
        return $stmt->execute([':pk' => $pk, ':password' => $password]);
    }
}