<?php

namespace Libs\Database;

use PDOException;
use PDO;

class UsersTable
{

    private $db;

    public function __construct(MySQL $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function all()
    {
        $statement = $this->db->query("SELECT users.*, roles.name AS role FROM users 
            LEFT JOIN roles ON users.role_id = roles.id " );
        return $statement->fetchAll();
    }

    public function find($email, $password)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email");
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();

            if ($user) {
                if (password_verify($password, $user->password)) {
                    return $user;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function insert($data)
    {

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            $statement = $this->db->prepare(
                "INSERT INTO users (name, email, password, address, phone, created_at) 
                    VALUE (:name, :email, :password, :address, :phone,  NOW())"
            );
            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function updatePhoto($id, $photo)
    {
        $statement = $this->db->prepare("UPDATE users SET photo=:photo WHERE id=:id");
        $statement->execute(['id' => $id, 'photo' => $photo]);

        return $statement->rowCount();
    }

    public function suspend($id)
    {
        $statement = $this->db->prepare("UPDATE users SET suspended=1 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function unsuspend($id)
    {
        $statement = $this->db->prepare("UPDATE users SET suspended=0 WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function changeRole($id, $role_id)
    {
        $statement = $this->db->prepare("UPDATE users SET role_id=:role_id WHERE id=:id");
        $statement->execute(['id' => $id, 'role_id' => $role_id]);

        return $statement->rowCount();
    }

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function findByEmail($email)
    {
        $statement = $this->db->prepare("SELECT id, email FROM users WHERE email = ?");
        $statement->execute([$email]);
        return $statement->fetch(); // returns user or false/null if not found
    }

    public function showAllUsers($limit = 10, $offset = 0)
    {
        $statement = $this->db->prepare("SELECT users.*, roles.name AS role FROM users 
            LEFT JOIN roles ON users.role_id = roles.id WHERE roles.id != 3 ORDER BY id DESC
            LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function totalCount()
    {
        $statement = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function saveRememberToken($user_id, $token)
{
    try {
        $statement = $this->db->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
        $statement->execute([
            'token' => $token,
            'id' => $user_id
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

public function findByToken($token)
{
    try {
        $statement = $this->db->prepare("SELECT * FROM users WHERE remember_token = :token");
        $statement->execute(['token' => $token]);
        return $statement->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

public function findById($id)
{
    try {
        $statement = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}


}
