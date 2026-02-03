<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../includes/Validator.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TaskController.php';
require_once __DIR__ . '/../controllers/TodoController.php';

Session::start();

$action = getGet('action', 'login');

if (!Session::isLoggedIn() && !in_array($action, ['login', 'register'])) {
    redirect('?action=login');
}

if (Session::isLoggedIn() && in_array($action, ['login', 'register'])) {
    redirect('?action=tasks');
}

$authController = new AuthController($mysqli);
$taskController = new TaskController($mysqli);
$todoController = new TodoController($mysqli);

$content = '';

switch ($action) {
    case 'register':
        $data = $authController->register();
        ob_start();
        include __DIR__ . '/../views/register.php';
        $content = ob_get_clean();
        break;

    case 'login':
        $data = $authController->login();
        // Extract errors and csrf_token for the view
        $errors = isset($data['errors']) ? $data['errors'] : [];
        $csrf_token = isset($data['csrf_token']) ? $data['csrf_token'] : '';
        ob_start();
        include __DIR__ . '/../views/login.php';
        $content = ob_get_clean();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'tasks':
        $data = $taskController->list();
        // Extract tasks and csrf_token for the view
        $tasks = isset($data['tasks']) ? $data['tasks'] : [];
        $csrf_token = isset($data['csrf_token']) ? $data['csrf_token'] : '';
        ob_start();
        include __DIR__ . '/../views/tasks.php';
        $content = ob_get_clean();
        break;

    case 'create':
        $data = $taskController->create();
        // Extract errors and csrf_token for the view
        $errors = isset($data['errors']) ? $data['errors'] : [];
        $csrf_token = isset($data['csrf_token']) ? $data['csrf_token'] : '';
        ob_start();
        include __DIR__ . '/../views/create-task.php';
        $content = ob_get_clean();
        break;

    case 'view':
        $data = $taskController->view();
        extract($data);
        ob_start();
        include __DIR__ . '/../views/task-detail.php';
        $content = ob_get_clean();
        break;

    case 'edit':
        $data = $taskController->edit();
        extract($data);
        ob_start();
        include __DIR__ . '/../views/edit-task.php';
        $content = ob_get_clean();
        break;

    case 'delete':
        $taskController->delete();
        break;

    case 'create_todo':
        $todoController->create();
        break;

    case 'edit_todo':
        $todo_id = (int)getGet('id');
        $task_id = (int)getGet('task_id');
        $todoModel = new Todo($mysqli);
        $todo = $todoModel->getById($todo_id);

        if (!$todo) {
            setFlash('error', 'Todo item not found');
            redirect('?action=tasks');
        }

        ob_start();
        include __DIR__ . '/../views/edit-todo.php';
        $content = ob_get_clean();
        break;

    case 'update_todo':
        $todoController->update();
        break;

    case 'toggle_todo':
        $todoController->toggleComplete();
        break;

    case 'delete_todo':
        $todoController->delete();
        break;

    default:
        redirect('?action=login');
}

include __DIR__ . '/../views/layout.php';

?>
