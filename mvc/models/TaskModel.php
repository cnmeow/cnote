<?php
class TaskModel extends Database
{
    /* 
     CREATE TABLE tasks (
        id SERIAL PRIMARY KEY,
        userId INTEGER REFERENCES users(id) ON DELETE CASCADE,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        duedate DATE,
        status INTEGER
    );
    */

    /* getAllTaskByUser() returns all tasks of a user by userId. */ 
    public function getAllTasksByUser($userId)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUndoneTasksByUser($userId)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 0 ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDoneTasksByUser($userId)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 1 ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllDeletedTasksByUser($userId)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = -1 ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /* getUserIdOfTask() returns userId of a task by taskId */
    public function getUserIdOfTask($taskId)
    {
        $query = "SELECT userId FROM tasks WHERE id = :taskId";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':taskId', $taskId);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['userId'];
    }
    
    /* getTask() get task by id then return task */
    public function getTask($id) {
        $query = "SELECT * FROM tasks WHERE id = :id ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /* addTask() add a new task to tasks table */
    public function addTask($userId, $title, $content, $duedate, $status)
    {
        $query = "INSERT INTO tasks (userId, title, content, duedate, status) VALUES (:userId, :title, :content, :duedate, :status)";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->bindParam(':duedate', $duedate);
        $statement->bindParam(':status', $status);

        $statement->execute();
    }

    /* updateTask() update task by id */
    public function updateTask($id, $title, $content, $duedate, $status)
    {
        $query = "UPDATE tasks SET title = :title, content = :content, duedate = :duedate, status = :status WHERE id = :id";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->bindParam(':duedate', $duedate);
        $statement->bindParam(':status', $status);

        $statement->execute();
    }

    /* softDeleteTask() delete task by id, but can restore */
    public function changeStatus($id, $newStatus)
    {
        $query = "UPDATE tasks SET status = :newStatus WHERE id = :id";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':newStatus', $newStatus);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
        
    /* deleteAllTaskByUser() delete all tasks of a user by userId */
    public function deleteAllTaskByUser($userId)
    {
        $query = "DELETE FROM tasks WHERE userId = :userId";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);

        $statement->execute();
    }

    public function findUndoneByTitle($userId, $title)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 0 AND LOWER(title) LIKE LOWER(:title) ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindValue(':title', '%' . $title . '%');
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findDoneByTitle($userId, $title)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 1 AND LOWER(title) LIKE LOWER(:title) ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindValue(':title', '%' . $title . '%');
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findUndoneByDate($userId, $date)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 0 AND duedate = :date ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':date', $date);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findDoneByDate($userId, $date)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 1 AND duedate = :date ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':date', $date);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function findUndoneByTitleAndDate($userId, $title, $date)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 0 AND LOWER(title) LIKE LOWER(:title) AND duedate = :date ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindValue(':title', '%' . $title . '%');
        $statement->bindParam(':date', $date);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findDoneByTitleAndDate($userId, $title, $date)
    {
        $query = "SELECT * FROM tasks WHERE userId = :userId AND status = 1 AND LOWER(title) LIKE LOWER(:title) AND duedate = :date ORDER BY duedate ASC";
        $statement = $this->con->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->bindValue(':title', '%' . $title . '%');
        $statement->bindParam(':date', $date);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
