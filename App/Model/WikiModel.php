<?php

namespace MyApp\Model;

use MyApp\Config\DbConnection;
use MyApp\Entity\WikiEntity;
use PDO;
use PDOException;

class WikiModel {
    private $db;

    public function __construct()
    {
        $this->db = DbConnection::getInstance()->getConnection();
    }

    public function getTagsForWiki($wikiId) {
        $stmt = $this->db->prepare("
            SELECT t.name 
            FROM tags t
            JOIN wikitags wt ON t.id = wt.tagId
            WHERE wt.wikiId = ?
        ");
        $stmt->execute([$wikiId]);
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($tag) {
            return $tag['name'];
        }, $tags);
    }
    public function getAllWikis() {
        $query = "
            SELECT 
                wikis.*, 
                categories.name as categoryName
            FROM 
                wikis
                LEFT JOIN categories ON wikis.categoryId = categories.id
            WHERE 
                wikis.deletedAt IS NULL
        ";
    
        try {
            $stmt = $this->db->query($query);
            $wikis = [];
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $wikis[] = $row; 
            }
    
            return $wikis; 
        } catch (PDOException $e) {
        }
    }
    
    

    public function getAllWikisWithTags() {
        $sql = "SELECT w.*, GROUP_CONCAT(t.name) AS tags
                FROM wikis w
                LEFT JOIN wikitags wt ON w.id = wt.wikiId
                LEFT JOIN tags t ON wt.tagId = t.id
                WHERE w.deletedAt IS NULL
                GROUP BY w.id";
    
        $result = $this->db->query($sql);
    
        if ($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    
    

    public function deleteWiki($wikiId) {
        try {
            $deleteTagsQuery = "DELETE FROM wikitags WHERE wikiId = :wikiId";
            $deleteTagsStmt = $this->db->prepare($deleteTagsQuery);
            $deleteTagsStmt->bindValue(':wikiId', $wikiId, PDO::PARAM_INT);
            $deleteTagsStmt->execute();
    
            $deleteWikiQuery = "DELETE FROM wikis WHERE id = :wikiId";
            $deleteWikiStmt = $this->db->prepare($deleteWikiQuery);
            $deleteWikiStmt->bindValue(':wikiId', $wikiId, PDO::PARAM_INT);
            $deleteWikiStmt->execute();
    
            return true; 
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false; 
        }
    }

    
    public function updateWiki($wikiId, $title, $content, $categoryId, $image) {
        try {
            if ($image) {
                $stmt = $this->db->prepare("UPDATE wikis SET title = ?, content = ?, categoryId = ?, imgLink = ? WHERE id = ?");
                $stmt->execute([$title, $content, $categoryId, $image, $wikiId]);
            } else {
                $stmt = $this->db->prepare("UPDATE wikis SET title = ?, content = ?, categoryId = ? WHERE id = ?");
                $stmt->execute([$title, $content, $categoryId, $wikiId]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Failed to update wiki: " . $e->getMessage());
            return false; 
        }
    }
    

    public function updateWikiTags($wikiId, $tagIds) {
        try {
            $deleteStmt = $this->db->prepare("DELETE FROM wikitags WHERE wikiId = ?");
            $deleteStmt->execute([$wikiId]);
    
            $insertStmt = $this->db->prepare("INSERT INTO wikitags (wikiId, tagId) VALUES (?, ?)");
            foreach ($tagIds as $tagId) {
                $insertStmt->execute([$wikiId, $tagId]);
            }
    
            return true; 
        } catch (PDOException $e) {
            error_log("Failed to update wiki tags: " . $e->getMessage());
            return false; 
        }
    }
    
    
    public function getWikiById($wikiId) {
        $stmt = $this->db->prepare("SELECT * FROM wikis WHERE id = ?");
        $stmt->execute([$wikiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    


    public function saveWikiTags($wikiId, $tags) {
        foreach ($tags as $tagId) {
            try {
                $stmt = $this->db->prepare("INSERT INTO wikitags (wikiId, tagId) VALUES (?, ?)");
                $stmt->execute([$wikiId, $tagId]);
            } catch (PDOException $e) {
                
            }
        }
    }
    
    public function getAllTags() {
        $stmt = $this->db->query("SELECT * FROM tags");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserName($userId) {
        $stmt = $this->db->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $user['name'] : null;
    }
    
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoryName($categoryId) {
        $stmt = $this->db->prepare("SELECT name FROM categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ? $category['name'] : null;
    }

    public function getWikisByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM wikis WHERE userId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    
    public function saveWiki(WikiEntity $wiki) {
        try {
            $stmt = $this->db->prepare("INSERT INTO wikis (imgLink, title, content, categoryId, userId) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$wiki->getImage(), $wiki->getTitle(), $wiki->getContent(), $wiki->getCategoryId(), $wiki->getUserId()]);
            return $this->db->lastInsertId(); 
        } catch (PDOException $e) {
            return null;
        }
    }


public function getWikisByCategory($categoryId) {
    $stmt = $this->db->prepare("SELECT * FROM wikis WHERE categoryId = ?");
    $stmt->execute([$categoryId]);
    $filteredArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);


    return $filteredArticles;
}

public function getWikisByTag($tag) {
    $sql = "SELECT w.*, GROUP_CONCAT(t.name) AS tags
            FROM wikis w
            LEFT JOIN wikitags wt ON w.id = wt.wikiId
            LEFT JOIN tags t ON wt.tagId = t.id
            WHERE w.deletedAt IS NULL AND t.name = :tag
            GROUP BY w.id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}



public function getAllWikisDash() {
    $query = "
        SELECT 
            wikis.*, 
            categories.name as categoryName
        FROM 
            wikis
            LEFT JOIN categories ON wikis.categoryId = categories.id
    ";

    try {
        $stmt = $this->db->query($query);
        $wikis = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $wikis[] = $row; 
        }

        return $wikis;
    } catch (PDOException $e) {
    }
}


public function unarchiveWiki($wikiId) {
    try {
        $stmt = $this->db->prepare("UPDATE wikis SET deletedAt = NULL WHERE id = ?");
        $stmt->execute([$wikiId]);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to unarchive wiki: " . $e->getMessage());
        return false;
    }
}

    public function archiveWiki($wikiId, $timestamp) {
        $stmt = $this->db->prepare("UPDATE wikis SET deletedAt = ? WHERE id = ?");
        $result = $stmt->execute([$timestamp, $wikiId]);
    
        return $result;
    }
    
}
