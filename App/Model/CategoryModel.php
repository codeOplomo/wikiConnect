<?php

namespace MyApp\Model;

use MyApp\Config\DbConnection;
use PDO;
use PDOException;

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = DbConnection::getInstance()->getConnection();
    }

    public function categoryExists($categoryName) {
        // Convert the entered category name to lowercase
        $categoryNameLower = strtolower($categoryName);

        // Check if the category name (lowercase) already exists
        $checkQuery = "SELECT COUNT(*) FROM categories WHERE LOWER(name) = :categoryNameLower";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':categoryNameLower', $categoryNameLower, PDO::PARAM_STR);
        $checkStmt->execute();

        return $checkStmt->fetchColumn() > 0;
    }

    public function deleteCategory($categoryId) {
        try {
            // Perform the deletion
            $deleteQuery = "DELETE FROM categories WHERE id = :categoryId";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    
            return $deleteStmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    
    public function updateCategory($categoryId, $newCategoryName) {
        try {
            if ($this->categoryExists($newCategoryName)) {
                // New category name already exists
                return false;
            } else {
                // Update the category name with the new one
                $updateQuery = "UPDATE categories SET name = :newCategoryName WHERE id = :categoryId";
                $updateStmt = $this->db->prepare($updateQuery);
                $updateStmt->bindParam(':newCategoryName', $newCategoryName, PDO::PARAM_STR);
                $updateStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

                return $updateStmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }


    public function addCategory($categoryName) {
        try {
            if ($this->categoryExists($categoryName)) {
                // Category already exists
                return false;
            } else {
                // Insert the category name as entered by the user
                $insertQuery = "INSERT INTO categories (name) VALUES (:categoryName)";
                $insertStmt = $this->db->prepare($insertQuery);
                $insertStmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);

                return $insertStmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
