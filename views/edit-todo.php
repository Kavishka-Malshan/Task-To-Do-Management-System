<?php Session::start(); ?>

<div class="form-container">
    <h1>Edit To-Do Item</h1>

    <form method="POST" action="?action=update_todo" class="task-form">
        <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="form-group">
            <label for="text">To-Do Text *</label>
            <input type="text" id="text" name="text" required
                   value="<?php echo htmlspecialchars($todo['text']); ?>"
                   maxlength="500" placeholder="Enter to-do text">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update To-Do</button>
            <a href="?action=view&id=<?php echo $task_id; ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
