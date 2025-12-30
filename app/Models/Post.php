<?php

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll($filters = []) {
        $sql = "SELECT p.*, a.name as author_name 
                FROM posts p 
                LEFT JOIN admins a ON p.author_id = a.id 
                WHERE 1=1";
        $params = [];
        
        // Search by title
        if (!empty($filters['search'])) {
            $sql .= " AND p.title LIKE :search";
            $params['search'] = '%' . $filters['search'] . '%';
        }
        
        // Filter by category
        if (!empty($filters['category'])) {
            $sql .= " AND p.category = :category";
            $params['category'] = $filters['category'];
        }
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = :status";
            $params['status'] = $filters['status'];
        }
        
        $sql .= " ORDER BY p.id DESC";
        
        return $this->db->fetchAll($sql, $params);
    }

    public function getPublished($limit = null) {
        $sql = "SELECT p.*, a.name as author_name 
                FROM posts p 
                LEFT JOIN admins a ON p.author_id = a.id 
                WHERE p.status = 'published' 
                ORDER BY p.created_at DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->fetchAll($sql);
    }

    public function findById($id) {
        // Ensure ID is integer
        $id = (int)$id;
        error_log("Post::findById called with ID: " . $id);
        
        $result = $this->db->fetchOne(
            "SELECT p.*, a.name as author_name 
             FROM posts p 
             LEFT JOIN admins a ON p.author_id = a.id 
             WHERE p.id = :id",
            ['id' => $id]
        );
        
        error_log("Post::findById result: " . ($result ? 'found' : 'not found'));
        return $result;
    }

    public function findBySlug($slug) {
        return $this->db->fetchOne(
            "SELECT p.*, a.name as author_name 
             FROM posts p 
             LEFT JOIN admins a ON p.author_id = a.id 
             WHERE p.slug = :slug AND p.status = 'published'",
            ['slug' => $slug]
        );
    }

    public function getByCategory($category, $limit = null) {
        $sql = "SELECT p.*, a.name as author_name 
                FROM posts p 
                LEFT JOIN admins a ON p.author_id = a.id 
                WHERE p.category = :category AND p.status = 'published' 
                ORDER BY p.created_at DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->fetchAll($sql, ['category' => $category]);
    }

    public function incrementViews($id) {
        $this->db->query("UPDATE posts SET views = views + 1 WHERE id = :id", ['id' => $id]);
    }

    public function create($data) {
        return $this->db->insert('posts', $data);
    }

    public function update($id, $data) {
        return $this->db->update('posts', $data, 'id = :id', ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('posts', 'id = :id', ['id' => $id]);
    }
}

