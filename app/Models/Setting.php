<?php

class Setting {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $settings = $this->db->fetchAll("SELECT `key`, `value`, type FROM settings");
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }
        return $result;
    }

    public function get($key, $default = null) {
        $setting = $this->db->fetchOne("SELECT `value` FROM settings WHERE `key` = :key", ['key' => $key]);
        return $setting ? $setting['value'] : $default;
    }

    public function set($key, $value) {
        $existing = $this->db->fetchOne("SELECT id FROM settings WHERE `key` = :key", ['key' => $key]);
        if ($existing) {
            return $this->db->update('settings', ['value' => $value], '`key` = :key', ['key' => $key]);
        } else {
            return $this->db->insert('settings', ['key' => $key, 'value' => $value]);
        }
    }
}

