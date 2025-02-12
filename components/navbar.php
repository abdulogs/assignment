<header class="navbar">
    <div class="boxed">
        <a href="index.php">
            <h3>Assignment</h3>
        </a>
        <?php if (session()->has("id")): ?>
            <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
        <?php endif; ?>
    </div>
</header>