<?php Session::start(); ?>

<div class="tasks-container">
    <div class="tasks-header">
        <h1>My Tasks</h1>
        <a href="?action=create" class="btn btn-primary">+ New Task</a>
    </div>

    <?php if (empty($tasks)): ?>
        <div class="empty-state">
            <p>No tasks yet. <a href="?action=create">Create one now</a></p>
        </div>
    <?php else: ?>
        <div class="tasks-list">
            <?php foreach ($tasks as $task): ?>
                <div class="task-card">
                    <div class="task-header">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <span class="task-date"><?php echo date('M d, Y', strtotime($task['created_at'])); ?></span>
                    </div>
                    <?php if (!empty($task['description'])): ?>
                        <p class="task-description"><?php echo htmlspecialchars(substr($task['description'], 0, 100)); ?><?php echo strlen($task['description']) > 100 ? '...' : ''; ?></p>
                    <?php endif; ?>
                    <div class="task-actions">
                        <a href="?action=view&id=<?php echo $task['id']; ?>" class="btn btn-secondary">View</a>
                        <a href="?action=edit&id=<?php echo $task['id']; ?>" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="?action=delete&id=<?php echo $task['id']; ?>" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
