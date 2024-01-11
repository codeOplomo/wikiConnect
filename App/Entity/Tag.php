<?php
namespace MyApp\Entity;

class Tag {
    private $id;
    private $name;

    // Constructor
    public function __construct($name) {
        $this->name = $name;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }
}
