<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByUsername($username) {
        return $this->db->fetchOne(
            "SELECT * FROM admins WHERE username = :username",
            ['username' => $username]
        );
    }

    public function findByEmail($email) {
        return $this->db->fetchOne(
            "SELECT * FROM admins WHERE email = :email",
            ['email' => $email]
        );
    }

    public function findById($id) {
        return $this->db->fetchOne(
            "SELECT * FROM admins WHERE id = :id",
            ['id' => $id]
        );
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT id, username, email, name, role, created_at FROM admins ORDER BY id DESC");
    }

    public function create($data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->db->insert('admins', $data);
    }

    public function update($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        return $this->db->update('admins', $data, 'id = :id', ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('admins', 'id = :id', ['id' => $id]);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}

