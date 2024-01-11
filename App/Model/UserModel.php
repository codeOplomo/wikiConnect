<?php

namespace MyApp\Model;

use MyApp\Config\DbConnection;
use MyApp\Entity\User;
use PDO;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = DbConnection::getInstance()->getConnection();
    }

    public function isEmailTaken($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function registerUser($username, $email, $password, $phone)
    {
        $user = new User($username, $email, $password, $phone, 2); 
        $hashedPassword = $user->getPassword();

        $stmt = $this->db->prepare("INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $phone, $email, $hashedPassword, $user->getRole()]);

        return $stmt->rowCount() > 0;
    }

    public function getUserDetailsByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
