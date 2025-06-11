<?php

namespace App\Gateways;

class ProdutoGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $sth = $this->db->prepare(
            "SELECT * FROM products"
        );

        try {
            $sth->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function filter($status = null, $inicio = null, $fim = null)
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if ($status !== null) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }

        if ($inicio !== null) {
            $sql .= " AND warranty_time >= :inicio";
            $params[':inicio'] = $inicio;
        }

        if ($fim !== null) {
            $sql .= " AND warranty_time <= :fim";
            $params[':fim'] = $fim;
        }

        $sth = $this->db->prepare($sql);
        $sth->execute($params);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sth = $this->db->prepare(
            "SELECT * FROM products WHERE id = :id"
        );

        try {
            $sth->bindValue('id', $id);
            $sth->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }    

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function insert(Array $input)
    {
        $this->db->beginTransaction();

        $sth = $this->db->prepare(
            "INSERT INTO products (
                description, 
                status, 
                warranty_time, 
                created_at, 
                updated_at
            ) VALUES (
                :description, 
                :status, 
                :warranty_time, 
                NOW(), 
                NOW()
            );"
        );

        try {
            $sth->bindValue('description', $input['description']);
            $sth->bindValue('status', $input['status']);
            $sth->bindValue('warranty_time', $input['warranty_time']);
            $sth->execute();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw new \Exception($e->getMessage());
        }    

        $this->db->commit();
        return 1;
    }

    public function update($id, Array $input)
    {
        $this->db->beginTransaction();

        $sth = $this->db->prepare(
            "UPDATE products SET
                description = :description,
                status = :status,
                warranty_time = :warranty_time, 
                updated_at = NOW()
            WHERE id = :id"
        );

        try {
            $sth->bindValue('description', $input['description']);
            $sth->bindValue('status', $input['status']);
            $sth->bindValue('warranty_time', $input['warranty_time']);
            $sth->bindValue('id', $id);
            $sth->execute();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw new \Exception($e->getMessage());
        }    

        $this->db->commit();

        return 1;
    }

    public function delete($id)
    {
        $this->db->beginTransaction();

        $sth = $this->db->prepare(
            "DELETE FROM products WHERE id = :id"
        );

        try {
            $sth->bindValue('id', $id);
            $sth->execute();
        } catch (\PDOException $e) {
            $this->db->rollBack();
            throw new \Exception($e->getMessage());
        }        

        $this->db->commit();
        return 1;
    }
}