<?php

namespace Libs\Database;

use PDO;
use PDOException;
class BooksTable
{
    private $db;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

     public function insertBook($data)
    {

        
        try{
                $statement = $this->db->prepare(
                    "INSERT INTO books (author_id, category_id, title, publisher, published_date, description, photo, created_at, file) 
                    VALUE (:author_id, :category_id, :title, :publisher, :published_date, :description, :photo, NOW(), :file)"
                );
                $statement->execute($data);
                return $this->db->lastInsertId();
            } 
            catch(PDOException $e){
                echo $e->getMessage();
                exit();
            }
    } 
    

      public function showAll($limit = 10, $offset = 0)
    {
        $statement = $this->db->prepare("SELECT b.id, b.title, a.name AS author, 
        c.name AS category, b.photo, b.file, temp_delete FROM books b
        LEFT JOIN authors a ON b.author_id = a.id
        LEFT JOIN categories c ON b.category_id = c.id ORDER BY id DESC
        LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Method to get total record count
    public function totalCount()
    {
        $statement = $this->db->query("SELECT COUNT(*) as total FROM books");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

     public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM books WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function updatePhoto($id, $photo){
        $statement = $this->db->prepare("UPDATE books SET photo=:photo WHERE id=:id");
        $statement->execute(['id' => $id, 'photo' => $photo]);

        return $statement->rowCount();
        }

    public function find($id)
    {
      // echo $id; 
        try {
            $statement = $this->db->prepare("SELECT * FROM books WHERE id = :id");
            $statement->execute(['id' => $id]);
           // return $statement->fetch(); 
           return $statement->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

     public function update($id, $author_id, $category_id, $title, $publisher,
      $published_date, $description, $photo, $file)
    {
        try {
            $statement = $this->db->prepare("UPDATE books 
            SET author_id=:author_id, category_id=:category_id, title=:title, publisher=:publisher,
             published_date=:published_date, description=:description,
              photo=:photo, file=:file WHERE id = :id");

            $statement->execute(['id' => $id, 'author_id' => $author_id, 'category_id' => $category_id,
            'title' => $title, 'publisher' => $publisher, 'published_date' => $published_date, 
            'description' => $description, 'photo' => $photo, 'file' => $file]);
            return $statement->rowCount(); 
        } catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

     public function showBook($id)
    {
        $statement = $this->db->prepare("UPDATE books SET temp_delete=0 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }  

     public function hideBook($id)
    {
        $statement = $this->db->prepare("UPDATE books SET temp_delete=1 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }  
    
}