<?php

namespace Libs\Database;

use PDO;

use PDOException;

class CategoriesTable
{
    private $db;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function insertCategories($data)
    {
        try {
            $statement = $this->db->prepare(
                "INSERT INTO categories (name, created_at) 
                    VALUE (:name, NOW())"
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
        $statement = $this->db->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT :limit OFFSET :offset ");
        $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function totalCount()
    {
        $statement = $this->db->query("SELECT COUNT(*) as total FROM categories");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM categories WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function find($id)
    {
        // echo $id; 
        try {
            $statement = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
            $statement->execute(['id' => $id]);
            // return $statement->fetch(); 
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function update($id, $name)
    {
        try {
            $statement = $this->db->prepare("UPDATE categories SET name=:name WHERE id = :id");
            $statement->execute(['id' => $id, 'name' => $name]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
     public function showCategory($id)
    {
        $statement = $this->db->prepare("UPDATE categories SET temp_delete=0 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function hideCategory($id)
    {
        $statement = $this->db->prepare("UPDATE categories SET temp_delete=1 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }
}
