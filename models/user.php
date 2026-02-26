<?php

namespace hfm\models;

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save($data)
    {
        try {
            $existing = $this->db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
            $existing->execute([':email' => $data['email']]);
            if ($existing->fetch()) {
                return array('status' => false, 'id' => null, 'error' => 'This email is already registered.');
            }

            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $register = $this->db->prepare("INSERT INTO users (fname, lname, country, prefix, phone, email, password) VALUES (:fname, :lname, :country, :prefix, :phone, :email, :password)");
            $register->execute([
                ':fname' => $data['fname'],
                ':lname' => $data['lname'],
                ':country' => $data['country'],
                ':prefix' => $data['prefix'],
                ':phone' => $data['phone'],
                ':email' => $data['email'],
                ':password' => $password
            ]);
            return array('status' => true, 'id' => $this->db->lastInsertId());
        } catch (\Throwable $th) {
            return array('status' => false, 'id' => null, 'error' => 'Unable to create account right now.');
        }
    }

    public function login($email, $password)
    {

        try {
            $user = $this->db->prepare("SELECT * FROM users where email = :email");
            $user->execute(['email' => $email]);
            $user = $user->fetch();
            if (password_verify($password, $user['password'])) {
                return array('status' => true, 'id' => $user['id']);
            }
            return array('status' => false, 'id' => null);
        } catch (\Throwable $th) {
            return array('status' => false, 'id' => null);
        }

    }


}