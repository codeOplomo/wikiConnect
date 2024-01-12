<?php

namespace MyApp\Model;

use MyApp\Config\DbConnection;
use PDO;
use PDOException;

class TagModel {
    private $db;

    public function __construct() {
        $this->db = DbConnection::getInstance()->getConnection();
    }

    public function tagExists($tagName) {
        // Convert the entered tag name to lowercase
        $tagNameLower = strtolower($tagName);

        // Check if the tag name (lowercase) already exists
        $checkQuery = "SELECT COUNT(*) FROM tags WHERE LOWER(name) = :tagNameLower";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':tagNameLower', $tagNameLower, PDO::PARAM_STR);
        $checkStmt->execute();

        return $checkStmt->fetchColumn() > 0;
    }

    public function deleteTag($tagId) {
        try {
            // Perform the deletion
            $deleteQuery = "DELETE FROM tags WHERE id = :tagId";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
    
            return $deleteStmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateTag($tagId, $newTagName) {
        try {
            if ($this->tagExists($newTagName)) {
                // New tag name already exists
                return false;
            } else {
                // Update the tag name with the new one
                $updateQuery = "UPDATE tags SET name = :newTagName WHERE id = :tagId";
                $updateStmt = $this->db->prepare($updateQuery);
                $updateStmt->bindParam(':newTagName', $newTagName, PDO::PARAM_STR);
                $updateStmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);

                return $updateStmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function addTag($tagName) {
        try {
            if ($this->tagExists($tagName)) {
                // Tag already exists
                return false;
            } else {
                // Insert the tag name as entered by the user
                $insertQuery = "INSERT INTO tags (name) VALUES (:tagName)";
                $insertStmt = $this->db->prepare($insertQuery);
                $insertStmt->bindParam(':tagName', $tagName, PDO::PARAM_STR);

                return $insertStmt->execute();
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    // public function getTagId($tagName) {
    //     $sql = "SELECT id FROM tags WHERE name = :tagName";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindValue(':tagName', $tagName, PDO::PARAM_STR);
    //     $stmt->execute();
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if ($result) {
    //         return $result['id'];
    //     }
    //    return null;
    // }
    public function getAllTags() {
        $stmt = $this->db->query("SELECT * FROM tags");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
