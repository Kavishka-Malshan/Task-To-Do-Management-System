<?php

class Todo {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function create($task_id, $text) {
        $stmt = $this->mysqli->prepare("INSERT INTO todos (task_id, text) VALUES (?, ?)");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("is", $task_id, $text);
        $result = $stmt->execute();
        $todo_id = $stmt->insert_id;
        $stmt->close();

        return $result ? $todo_id : false;
    }

    public function getById($id) {
        $stmt = $this->mysqli->prepare("SELECT id, task_id, text, is_completed, created_at FROM todos WHERE id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $todo = $result->num_rows > 0 ? $result->fetch_assoc() : false;
        $stmt->close();

        return $todo;
    }

    public function getByTaskId($task_id) {
        $stmt = $this->mysqli->prepare("SELECT id, task_id, text, is_completed, created_at FROM todos WHERE task_id = ? ORDER BY created_at DESC");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];

        while ($row = $result->fetch_assoc()) {
            $todos[] = $row;
        }

        $stmt->close();
        return $todos;
    }

    public function update($id, $text) {
        $stmt = $this->mysqli->prepare("UPDATE todos SET text = ? WHERE id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $text, $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function toggleComplete($id) {
        $stmt = $this->mysqli->prepare("UPDATE todos SET is_completed = !is_completed WHERE id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function delete($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM todos WHERE id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function todoOwnershipCheck($todo_id, $user_id) {
        $stmt = $this->mysqli->prepare("
            SELECT t.id FROM todos t
            JOIN tasks tk ON t.task_id = tk.id
            WHERE t.id = ? AND tk.user_id = ?
        ");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $todo_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        return $exists;
    }
}

?>
