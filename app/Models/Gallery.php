<?php

class Gallery {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM gallery ORDER BY id DESC");
    }

    public function getActive($limit = null) {
        $sql = "SELECT * FROM gallery WHERE status = 'active' ORDER BY id DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->fetchAll($sql);
    }

    public function getByCategory($category) {
        return $this->db->fetchAll(
            "SELECT * FROM gallery WHERE category = :category AND status = 'active' ORDER BY id DESC",
            ['category' => $category]
        );
    }

    public function findById($id) {
        return $this->db->fetchOne("SELECT * FROM gallery WHERE id = :id", ['id' => $id]);
    }

    public function create($data) {
        return $this->db->insert('gallery', $data);
    }

    public function update($id, $data) {
        return $this->db->update('gallery', $data, 'id = :id', ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('gallery', 'id = :id', ['id' => $id]);
    }
}

