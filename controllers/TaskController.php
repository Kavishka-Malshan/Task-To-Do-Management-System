<?php

require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Todo.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../includes/Validator.php';

class TaskController {
    private $taskModel;
    private $todoModel;
    private $validator;

    public function __construct($mysqli) {
        $this->taskModel = new Task($mysqli);
        $this->todoModel = new Todo($mysqli);
        $this->validator = new Validator();
    }

    public function list() {
        $user_id = Session::getUserId();
        $tasks = $this->taskModel->getAllByUser($user_id);

        return [
            'tasks' => $tasks,
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function create() {
        $user_id = Session::getUserId();

        if (isPost()) {
            $title = getPost('title');
            $description = getPost('description');

            if (!verifyCsrfToken(getPost('csrf_token'))) {
                $this->validator->addError('general', 'Invalid security token');
            } else {
                $this->validator->validateTaskTitle($title);

                if (!$this->validator->hasErrors()) {
                    if ($this->taskModel->create($user_id, $title, $description)) {
                        setFlash('success', 'Task created successfully');
                        redirect('?action=tasks');
                    } else {
                        $this->validator->addError('general', 'Failed to create task');
                    }
                }
            }
        }

        return [
            'errors' => $this->validator->getErrors(),
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function view() {
        $user_id = Session::getUserId();
        $task_id = (int)getGet('id');

        $task = $this->taskModel->getById($task_id, $user_id);
        if (!$task) {
            setFlash('error', 'Task not found');
            redirect('?action=tasks');
        }

        $todos = $this->todoModel->getByTaskId($task_id);

        return [
            'task' => $task,
            'todos' => $todos,
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function edit() {
        $user_id = Session::getUserId();
        $task_id = (int)getGet('id');

        $task = $this->taskModel->getById($task_id, $user_id);
        if (!$task) {
            setFlash('error', 'Task not found');
            redirect('?action=tasks');
        }

        if (isPost()) {
            $title = getPost('title');
            $description = getPost('description');

            if (!verifyCsrfToken(getPost('csrf_token'))) {
                $this->validator->addError('general', 'Invalid security token');
            } else {
                $this->validator->validateTaskTitle($title);

                if (!$this->validator->hasErrors()) {
                    if ($this->taskModel->update($task_id, $user_id, $title, $description)) {
                        setFlash('success', 'Task updated successfully');
                        redirect('?action=view&id=' . $task_id);
                    } else {
                        $this->validator->addError('general', 'Failed to update task');
                    }
                }
            }
        }

        return [
            'task' => $task,
            'errors' => $this->validator->getErrors(),
            'csrf_token' => generateCsrfToken()
        ];
    }

    public function delete() {
        $user_id = Session::getUserId();
        $task_id = (int)getGet('id');

        $task = $this->taskModel->getById($task_id, $user_id);
        if (!$task) {
            setFlash('error', 'Task not found');
            redirect('?action=tasks');
        }

        if (!verifyCsrfToken(getPost('csrf_token'))) {
            setFlash('error', 'Invalid security token');
            redirect('?action=view&id=' . $task_id);
        }

        if ($this->taskModel->delete($task_id, $user_id)) {
            setFlash('success', 'Task deleted successfully');
            redirect('?action=tasks');
        } else {
            setFlash('error', 'Failed to delete task');
            redirect('?action=view&id=' . $task_id);
        }
    }
}

?>
