<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task & To-Do Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">Task Manager</div>
            <ul class="nav-links">
                <?php if (Session::isLoggedIn()): ?>
                    <li><span class="username">Welcome, <?php echo htmlspecialchars(Session::getUsername()); ?></span></li>
                    <li><a href="?action=tasks">My Tasks</a></li>
                    <li><a href="?action=create">New Task</a></li>
                    <li><a href="?action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="?action=login">Login</a></li>
                    <li><a href="?action=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
        $success = getFlash('success');
        $error = getFlash('error');
        if ($success):
        ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php echo $content; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Task & To-Do Management System. All rights reserved.</p>
    </footer>
</body>
</html>
