<?php

namespace App\Gateways;

class UserGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public static function authentication(array $data)
    {

        $stmt = $pdo->prepare(
            "SELECT  * FROM users WHERE email = :email"
        );

        try {
            $sth->bindValue("email", $data['email']);
            $sth->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }  

        if ($sth->rowCount() < 1) return false;

        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($data['password'], $user['password'])) return false;

        return [
            'id'   => $user['id'],
            'name' => $user['name'],
            'email'=> $user['email'],
        ];
    }
}