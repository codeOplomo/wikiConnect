<?php

namespace MyApp\Entity;

class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $phone;
    private $role;


    public function __construct($username, $email, $password, $phone, $role) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->phone = $phone;
        $this->role = $role;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter and setter for email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Getter and setter for password
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT); 
    }

    // Getter and setter for phone
    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    // Getter and setter for role
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

}
