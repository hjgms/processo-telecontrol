<?php

namespace App\Utils;

class Logger {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function logAction($action, $details) {
        $query = "INSERT INTO logs (action, details, created_at) 
                  VALUES (:action, :details, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':action', $action);
        $stmt->bindValue(':details', $details);
        $stmt->execute();
    }

    public function logError($context, $error) {
        $this->logAction('ERROR_' . $context, $error);
    }
}