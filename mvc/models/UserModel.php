<?php
class UserModel extends Database
{
    /* 
    CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        email VARCHAR(255), // In next version, we can use email to login/reset password
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );
    */

    /* getUser() returns user if the username already exists, -1 otherwise. */
    public function getUser($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return -1;
        }
    }

    /* login() returns id of user if login success, -1 if username not exists, -2 if password incorrect. */
    public function login($username, $password)
    {
        // Check if username exists
        $result = $this->getUser($username);
        if ($result == -1) { // Username not exists
            return -1;
        }

        // Check if password correct
        if (password_verify($password, $result['password'])) {
            return $result['id'];
        } else {
            return -2;
        }
    }

    /* addUser() add a new user to users table, return id of new user if success, -1 otherwise. */
    public function addUser($username, $password)
    {
        // Check if username already exists
        $result = $this->getUser($username);
        if ($result != -1) { // Username already exists
            return -1;
        }

        // Add new user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $hashedPassword);

        $statement->execute();

        $result = $this->getUser($username);
        return $result['id'];
    }

    /* updateUser() update password of user */
    public function changePassword($id, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':password', $hashedPassword);

        $statement->execute();
    }

    /* deleteUser() delete user */
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':id', $id);

        $statement->execute();
    }
}