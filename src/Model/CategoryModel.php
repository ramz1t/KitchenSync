<?php

class CategoryModel
{
    public static function getAllCategories(PDO $pdo, int $restaurantPk): array
    {
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE restaurant_pk = :restaurant_pk ORDER BY position ASC');
        $stmt->execute([':restaurant_pk' => $restaurantPk]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoryById(PDO $pdo, int $pk): ?array
    {
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE pk = :pk');
        $stmt->execute([':pk' => $pk]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function createCategory(PDO $pdo, int $restaurantPk, string $name, int $position): array
    {
        $stmt = $pdo->prepare('INSERT INTO categories (restaurant_pk, name, position) VALUES (:restaurantPk, :name, :position)');
        $stmt->execute([
            ':restaurantPk' => $restaurantPk,
            ':name' => $name,
            ':position' => $position
        ]);
        return CategoryModel::getCategoryById($pdo, (int) $pdo->lastInsertId());
    }

    public static function updateCategory(PDO $pdo, int $pk, string $name, int $position): bool
    {
        $stmt = $pdo->prepare('UPDATE categories SET name = :name, position = :position WHERE pk = :pk');
        return $stmt->execute([':name' => $name, ':pk' => $pk, ':position' => $position]);
    }

    public static function deleteCategory(PDO $pdo, int $pk): bool
    {
        $stmt = $pdo->prepare('DELETE FROM categories WHERE pk = :pk');
        return $stmt->execute([':pk' => $pk]);
    }
}