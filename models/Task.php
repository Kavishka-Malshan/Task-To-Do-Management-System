<?php

class Task {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function create($user_id, $title, $description = '') {
        $stmt = $this->mysqli->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iss", $user_id, $title, $description);
        $result = $stmt->execute();
        $task_id = $stmt->insert_id;
        $stmt->close();

        return $result ? $task_id : false;
    }

    public function getById($id, $user_id) {
        $stmt = $this->mysqli->prepare("SELECT id, user_id, title, description, created_at, updated_at FROM tasks WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = $result->num_rows > 0 ? $result->fetch_assoc() : false;
        $stmt->close();

        return $task;
    }

    public function getAllByUser($user_id) {
        $stmt = $this->mysqli->prepare("SELECT id, user_id, title, description, created_at, updated_at FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        $stmt->close();
        return $tasks;
    }

    public function update($id, $user_id, $title, $description) {
        $stmt = $this->mysqli->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssii", $title, $description, $id, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function delete($id, $user_id) {
        $stmt = $this->mysqli->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $id, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}

?>
