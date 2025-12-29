<?php

class Carousel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM carousel ORDER BY order_position ASC, id DESC");
    }

    public function getActive($limit = null) {
        $sql = "SELECT * FROM carousel WHERE status = 'active' ORDER BY order_position ASC, id DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->fetchAll($sql);
    }

    public function findById($id) {
        return $this->db->fetchOne("SELECT * FROM carousel WHERE id = :id", ['id' => $id]);
    }

    public function create($data) {
        return $this->db->insert('carousel', $data);
    }

    public function update($id, $data) {
        return $this->db->update('carousel', $data, 'id = :id', ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('carousel', 'id = :id', ['id' => $id]);
    }
}

