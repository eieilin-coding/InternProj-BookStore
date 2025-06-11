<?php

namespace Libs\Database;

use PDOException;
class UsersTable
{
    private $db;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function insertUser($data)
    {

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        try{
                $statement = $this->db->prepare(
                    "INSERT INTO users (name, email, password, address, phone, created_at) 
                    VALUE (:name, :email, :password, :address, :phone,  NOW())"
                );
                $statement->execute($data);
                return $this->db->lastInsertId();
            } 
            catch(PDOException $e){
                echo $e->getMessage();
                exit();
            }
    }   

    public function getAll()
    {
            $statement = $this->db->query("SELECT * FROM users");
            return $statement->fetchAll();
    }

    public function find($email, $password)
    {
        try{
            $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email");
            $statement->execute(['email'=>$email]);
            $user=$statement->fetch();

            if($user){
                if(password_verify($password, $user->password)){
                    return $user;
                }
            }

        } catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

      public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    } 
        
}
