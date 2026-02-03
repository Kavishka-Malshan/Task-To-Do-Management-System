

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
                    <div class="todo-item clear-todo-item <?php echo $todo['is_completed'] ? 'completed' : ''; ?>">
                        <div class="clear-todo-main">
                            <form method="POST" action="?action=toggle_todo" style="display:inline; margin-right: 16px;">
                                <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <input type="checkbox" onchange="this.form.submit()" <?php echo $todo['is_completed'] ? 'checked' : ''; ?> style="width: 20px; height: 20px; vertical-align: middle;">
                            </form>
                            <span class="todo-text" style="font-size:1.08rem; margin-right: 18px; color:#2c3e50; min-width:120px; display:inline-block;"> <?php echo htmlspecialchars($todo['text']); ?> </span>
                            <span class="todo-date" style="color:#888; font-size:0.98rem; margin-right: 18px; min-width:150px; display:inline-block;"> <?php echo date('M d, Y H:i', strtotime($todo['created_at'])); ?> </span>
                            <div style="margin-left:auto; display:flex; gap:0.5rem; align-items:center;">
                                <a href="?action=edit_todo&id=<?php echo $todo['id']; ?>&task_id=<?php echo $task['id']; ?>" class="btn btn-small btn-secondary" style="display:flex; align-items:center; gap:4px;">
                                    <svg width="16" height="16" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                                    Edit
                                </a>
                                <form method="POST" action="?action=delete_todo" style="display:inline;" onsubmit="return confirm('Delete this item?');">
                                    <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <button type="submit" class="btn btn-small btn-danger" style="display:flex; align-items:center; gap:4px;">
                                        <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
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
