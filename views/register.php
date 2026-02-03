<?php Session::start(); ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Create Account</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="?action=register" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required
                       value="<?php echo htmlspecialchars(getPost('username')); ?>"
                       minlength="3" maxlength="100">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo htmlspecialchars(getPost('email')); ?>"
                       maxlength="120">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p class="auth-link">
            Already have an account? <a href="?action=login">Login here</a>
        </p>
    </div>
</div>
