<?php

namespace App\Gateways;

class ClienteGateway {

  private $db = null;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function findAll()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM clients"
    );

    try {
      $sth->execute();
    } catch (\PDOException $e) {
      throw new \Exception($e->getMessage());
    }

    $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
    
    return $result;
  }

  public function find($id)
  {
    $sth = $this->db->prepare(
      "SELECT * FROM clients WHERE id = :id"
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
      "INSERT INTO clients (
        name, 
        cpf, 
        address, 
        created_at, 
        updated_at
      ) VALUES (
        :name, 
        :cpf, 
        :address, 
        NOW(), 
        NOW()
      );"
    );

    try {
      $sth->bindValue('name', $input['name']);
      $sth->bindValue('cpf', $input['cpf']);
      $sth->bindValue('address', $input['address']);
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
      "UPDATE clients SET
        name = :name,
        cpf = :cpf, 
        address = :address, 
        updated_at = NOW()
      WHERE id = :id"
    );

    try {
      $sth->bindValue('name', $input['name']);
      $sth->bindValue('cpf', $input['cpf']);
      $sth->bindValue('address', $input['address']);
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
      "DELETE FROM clients WHERE id = :id"
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