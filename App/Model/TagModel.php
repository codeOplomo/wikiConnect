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
        $tagNameLower = strtolower($tagName);

        $checkQuery = "SELECT COUNT(*) FROM tags WHERE LOWER(name) = :tagNameLower";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':tagNameLower', $tagNameLower, PDO::PARAM_STR);
        $checkStmt->execute();

        return $checkStmt->fetchColumn() > 0;
    }

    public function deleteTag($tagId) {
        try {
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
                return false;
            } else {
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
                return false;
            } else {
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

   
    public function getAllTags() {
        $stmt = $this->db->query("SELECT * FROM tags");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
