<?php Session::start(); ?>

<div class="task-detail-container">
    <div class="task-detail-header">
        <h1><?php echo htmlspecialchars($task['title']); ?></h1>
        <p class="task-meta">Created: <?php echo date('M d, Y H:i', strtotime($task['created_at'])); ?></p>
    </div>

    <?php if (!empty($task['description'])): ?>
        <div class="task-description-block">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
        </div>
    <?php endif; ?>

    <div class="todos-section">
        <h2>To-Do Items</h2>

        <?php if (empty($todos)): ?>
            <p class="empty-todos">No to-do items yet. Add one below!</p>
        <?php else: ?>
            <div class="todos-list">
                <?php foreach ($todos as $todo): ?>
                    <div class="todo-item <?php echo $todo['is_completed'] ? 'completed' : ''; ?>">
                        <div class="todo-content">
                            <span class="todo-text"><?php echo htmlspecialchars($todo['text']); ?></span>
                            <span class="todo-date"><?php echo date('M d, Y', strtotime($todo['created_at'])); ?></span>
                        </div>
                        <div class="todo-actions">
                            <form method="POST" action="?action=toggle_todo" style="display:inline;">
                                <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <button type="submit" class="btn btn-small <?php echo $todo['is_completed'] ? 'btn-incomplete' : 'btn-complete'; ?>">
                                    <?php echo $todo['is_completed'] ? 'Mark Incomplete' : 'Mark Complete'; ?>
                                </button>
                            </form>
                            <a href="?action=edit_todo&id=<?php echo $todo['id']; ?>&task_id=<?php echo $task['id']; ?>" class="btn btn-small btn-secondary">Edit</a>
                            <form method="POST" action="?action=delete_todo" style="display:inline;" onsubmit="return confirm('Delete this item?');">
                                <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <button type="submit" class="btn btn-small btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?action=create_todo" class="add-todo-form">
            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <div class="form-group">
                <input type="text" name="text" placeholder="Add a new to-do item..." required maxlength="500">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>

    <div class="task-detail-actions">
        <a href="?action=edit&id=<?php echo $task['id']; ?>" class="btn btn-secondary">Edit Task</a>
        <form method="POST" action="?action=delete&id=<?php echo $task['id']; ?>" style="display:inline;" onsubmit="return confirm('Delete this task and all its to-do items?');">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <button type="submit" class="btn btn-danger">Delete Task</button>
        </form>
        <a href="?action=tasks" class="btn btn-secondary">Back to Tasks</a>
    </div>
</div>
