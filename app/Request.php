<?php

class Request {
    public static function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    public static function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    public static function input($key = null, $default = null) {
        $input = array_merge($_GET, $_POST);
        if ($key === null) {
            return $input;
        }
        return $input[$key] ?? $default;
    }

    public static function file($key) {
        return $_FILES[$key] ?? null;
    }

    public static function has($key) {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }

    public static function method() {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public static function isPost() {
        return self::method() === 'POST';
    }

    public static function isGet() {
        return self::method() === 'GET';
    }

    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function all() {
        return array_merge($_GET, $_POST);
    }

    /**
     * Check if request wants JSON response (Laravel-style)
     */
    public static function wantsJson() {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        return strpos($accept, 'application/json') !== false || 
               strpos($accept, 'json') !== false ||
               self::isAjax();
    }
}

