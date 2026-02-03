<?php Session::start(); ?>

<div class="form-container">
    <h1>Edit Task</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="?action=edit&id=<?php echo $task['id']; ?>" class="task-form">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="form-group">
            <label for="title">Task Title *</label>
            <input type="text" id="title" name="title" required
                   value="<?php echo htmlspecialchars($task['title']); ?>"
                   maxlength="255" placeholder="Enter task title">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"
                      placeholder="Enter task description (optional)"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="?action=view&id=<?php echo $task['id']; ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
