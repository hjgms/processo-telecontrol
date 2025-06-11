<?php

namespace App\Gateways;

class OrdemServicoGateway {

  private $db = null;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function findAll()
  {
    $sth = $this->db->prepare(
      "SELECT * FROM service_orders"
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
      "SELECT * FROM service_orders WHERE id = :id"
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
      "INSERT INTO service_orders (
        product_id, 
        client_id, 
        user_id, 
        status,
        created_at, 
        updated_at
      ) VALUES (
        :product_id, 
        :client_id, 
        :user_id, 
        :status, 
        NOW(), 
        NOW()
      );"
    );

    try {
      $sth->bindValue('product_id', $input['product_id']);
      $sth->bindValue('client_id', $input['client_id']);
      $sth->bindValue('user_id', $input['user_id']);
      $sth->bindValue('status', $input['status']);
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
      "UPDATE service_orders SET
        product_id = :product_id,
        client_id = :client_id, 
        status = :status, 
        updated_at = NOW()
      WHERE id = :id"
    );

    try {
      $sth->bindValue('product_id', $input['product_id']);
      $sth->bindValue('client_id', $input['client_id']);
      $sth->bindValue('status', $input['status']);
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
      "DELETE FROM service_orders WHERE id = :id"
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