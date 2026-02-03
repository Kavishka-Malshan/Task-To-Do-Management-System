

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
            <?php 
            $cardColors = ['#ff4081', '#2196f3', '#ffd600', '#4caf50', '#9c27b0', '#ff5252'];
            $icon = '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9l2 2l4-4"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>';
            $i = 0;
            foreach ($tasks as $task): 
                $color = $cardColors[$i % count($cardColors)];
            ?>
                <div class="task-card image-style-card">
                    <div class="image-style-bar" style="background: <?php echo $color; ?>;"></div>
                    <div class="image-style-icon"><?php echo $icon; ?></div>
                    <div class="image-style-content">
                        <h3 class="image-style-title"><?php echo htmlspecialchars($task['title']); ?></h3>
                        <span class="task-date"><?php echo date('M d, Y', strtotime($task['created_at'])); ?></span>
                        <?php if (!empty($task['description'])): ?>
                            <p class="image-style-description"><?php echo htmlspecialchars(substr($task['description'], 0, 100)); ?><?php echo strlen($task['description']) > 100 ? '...' : ''; ?></p>
                        <?php endif; ?>
                        <div class="image-style-actions">
                            <a href="?action=view&id=<?php echo $task['id']; ?>" class="btn btn-secondary">View</a>
                            <a href="?action=edit&id=<?php echo $task['id']; ?>" class="btn btn-secondary">Edit</a>
                            <form method="POST" action="?action=delete&id=<?php echo $task['id']; ?>" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php $i++; endforeach; ?>
        </div>
    <?php endif; ?>
</div>
