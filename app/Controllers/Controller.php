<?php

class Controller {
    protected function view($view, $data = []) {
        if (defined('IS_AJAX') && IS_AJAX) {
            return;
        }
        View::render($view, $data);
    }

    protected function json($data, $statusCode = 200) {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8', true);
        header('Cache-Control: no-cache, must-revalidate', true);
        
        $jsonOutput = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo $jsonOutput;
        exit(0);
    }

    protected function redirect($url) {
        Response::redirect($url);
    }

    protected function back() {
        Response::back();
    }

    protected function validate($rules) {
        $errors = [];
        foreach ($rules as $field => $rule) {
            $value = Request::input($field);
            $ruleParts = explode('|', $rule);
            
            foreach ($ruleParts as $rulePart) {
                if ($rulePart === 'required' && empty($value)) {
                    $errors[$field] = "Field {$field} is required";
                    break;
                }
                if (strpos($rulePart, 'min:') === 0) {
                    $min = (int)substr($rulePart, 4);
                    if (strlen($value) < $min) {
                        $errors[$field] = "Field {$field} must be at least {$min} characters";
                        break;
                    }
                }
                if ($rulePart === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Field {$field} must be a valid email";
                    break;
                }
            }
        }
        
        if (!empty($errors)) {
            Response::withErrors($errors)->withInput(Request::all());
            return false;
        }
        
        return true;
    }
}

