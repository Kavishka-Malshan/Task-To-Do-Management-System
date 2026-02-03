<?php

require_once __DIR__ . '/../models/Todo.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../includes/Validator.php';

class TodoController {
    private $todoModel;
    private $taskModel;
    private $validator;

    public function __construct($mysqli) {
        $this->todoModel = new Todo($mysqli);
        $this->taskModel = new Task($mysqli);
        $this->validator = new Validator();
    }

    public function create() {
        $user_id = Session::getUserId();
        $task_id = (int)getPost('task_id');

        $task = $this->taskModel->getById($task_id, $user_id);
        if (!$task) {
            setFlash('error', 'Task not found');
            redirect('?action=tasks');
        }

        if (!verifyCsrfToken(getPost('csrf_token'))) {
            setFlash('error', 'Invalid security token');
            redirect('?action=view&id=' . $task_id);
        }

        $text = getPost('text');
        $this->validator->validateTodoText($text);

        if (!$this->validator->hasErrors()) {
            if ($this->todoModel->create($task_id, $text)) {
                setFlash('success', 'Todo item added successfully');
            } else {
                setFlash('error', 'Failed to add todo item');
            }
        } else {
            setFlash('error', implode(', ', $this->validator->getErrors()));
        }

        redirect('?action=view&id=' . $task_id);
    }

    public function update() {
        $user_id = Session::getUserId();
        $todo_id = (int)getPost('todo_id');
        $task_id = (int)getPost('task_id');

        if (!$this->todoModel->todoOwnershipCheck($todo_id, $user_id)) {
            setFlash('error', 'Unauthorized');
            redirect('?action=tasks');
        }

        if (!verifyCsrfToken(getPost('csrf_token'))) {
            setFlash('error', 'Invalid security token');
            redirect('?action=view&id=' . $task_id);
        }

        $text = getPost('text');
        $this->validator->validateTodoText($text);

        if (!$this->validator->hasErrors()) {
            if ($this->todoModel->update($todo_id, $text)) {
                setFlash('success', 'Todo item updated successfully');
            } else {
                setFlash('error', 'Failed to update todo item');
            }
        } else {
            setFlash('error', implode(', ', $this->validator->getErrors()));
        }

        redirect('?action=view&id=' . $task_id);
    }

    public function toggleComplete() {
        $user_id = Session::getUserId();
        $todo_id = (int)getPost('todo_id');
        $task_id = (int)getPost('task_id');

        if (!$this->todoModel->todoOwnershipCheck($todo_id, $user_id)) {
            setFlash('error', 'Unauthorized');
            redirect('?action=tasks');
        }

        if (!verifyCsrfToken(getPost('csrf_token'))) {
            setFlash('error', 'Invalid security token');
            redirect('?action=view&id=' . $task_id);
        }

        if ($this->todoModel->toggleComplete($todo_id)) {
            setFlash('success', 'Todo item updated');
        } else {
            setFlash('error', 'Failed to update todo item');
        }

        redirect('?action=view&id=' . $task_id);
    }

    public function delete() {
        $user_id = Session::getUserId();
        $todo_id = (int)getPost('todo_id');
        $task_id = (int)getPost('task_id');

        if (!$this->todoModel->todoOwnershipCheck($todo_id, $user_id)) {
            setFlash('error', 'Unauthorized');
            redirect('?action=tasks');
        }

        if (!verifyCsrfToken(getPost('csrf_token'))) {
            setFlash('error', 'Invalid security token');
            redirect('?action=view&id=' . $task_id);
        }

        if ($this->todoModel->delete($todo_id)) {
            setFlash('success', 'Todo item deleted successfully');
        } else {
            setFlash('error', 'Failed to delete todo item');
        }

        redirect('?action=view&id=' . $task_id);
    }
}

?>
