<?php

namespace MyApp\Entity;

class WikiEntity {
    private $id;
    private $image;
    private $title;
    private $content;
    private $categoryId;
    private $userId;

    // Constructor
    public function __construct($id, $image, $title, $content, $categoryId, $userId) {
        $this->id = $id;
        $this->image = $image;
        $this->title = $title;
        $this->content = $content;
        $this->categoryId = $categoryId;
        $this->userId = $userId;
    }


    
    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function getUserId() {
        return $this->userId;
    }
    public function getImage() {
        return $this->image;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setContent($content) {
        $this->content = $content;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setImage($image) {
        $this->image = $image;
    }
}
