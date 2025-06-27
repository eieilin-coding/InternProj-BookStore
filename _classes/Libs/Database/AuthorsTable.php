<?php

namespace Libs\Database;

use PDO;
use PDOException;

class AuthorsTable
{
    private $db;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function insertAuthor($data)
    {
        try {
            $statement = $this->db->prepare(
                "INSERT INTO authors (name, email, phone, address) 
                    VALUE (:name, :email, :phone, :address)"
            );
            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function showAll($limit = 10, $offset = 0)
    {
        $statement = $this->db->prepare("SELECT * FROM authors ORDER BY id DESC LIMIT :limit OFFSET :offset ");
        $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function totalCount()
    {
        $statement = $this->db->query("SELECT COUNT(*) as total FROM authors");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }


    public function authorList()
    {
        $statement = $this->db->query("SELECT id, name FROM authors ORDER BY name");
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM authors WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function find($id)
    {
        // echo $id; 
        try {
            $statement = $this->db->prepare("SELECT * FROM authors WHERE id = :id");
            $statement->execute(['id' => $id]);
            // return $statement->fetch(); 
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function update($id, $name, $email, $phone, $address)
    {
        try {
            $statement = $this->db->prepare("UPDATE authors 
            SET name=:name, email=:email, phone=:phone, address=:address WHERE id = :id");
            $statement->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

     public function showAuthor($id)
    {
        $statement = $this->db->prepare("UPDATE authors SET temp_delete=0 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function hideAuthor($id)
    {
        $statement = $this->db->prepare("UPDATE authors SET temp_delete=1 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }
}
