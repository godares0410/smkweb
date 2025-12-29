<?php

class Page {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->fetchAll("SELECT * FROM pages ORDER BY id DESC");
    }

    public function getPublished() {
        return $this->db->fetchAll("SELECT * FROM pages WHERE status = 'published' ORDER BY id DESC");
    }

    public function findById($id) {
        return $this->db->fetchOne("SELECT * FROM pages WHERE id = :id", ['id' => $id]);
    }

    public function findBySlug($slug) {
        return $this->db->fetchOne("SELECT * FROM pages WHERE slug = :slug AND status = 'published'", ['slug' => $slug]);
    }

    public function create($data) {
        return $this->db->insert('pages', $data);
    }

    public function update($id, $data) {
        return $this->db->update('pages', $data, 'id = :id', ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('pages', 'id = :id', ['id' => $id]);
    }
}

