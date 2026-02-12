<?php
$current_page = isset($admin_current_page) ? $admin_current_page : '';
?>
<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <h1>Admin Panel</h1>
    </div>
    <nav class="admin-sidebar-nav">
        <a href="admin_dashboard.php" class="<?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
        <a href="manage_users.php" class="<?php echo $current_page === 'users' ? 'active' : ''; ?>">Manage Users</a>
        <a href="manage_orders.php" class="<?php echo $current_page === 'orders' ? 'active' : ''; ?>">Manage Orders</a>
        <a href="admin_contact_messages.php" class="<?php echo $current_page === 'messages' ? 'active' : ''; ?>">Contact messages</a>
        <a href="admin_components.php" class="<?php echo $current_page === 'components' ? 'active' : ''; ?>">Components</a>
        <a href="admin_inventory_search.php">Search inventory</a>
    </nav>
    <div class="admin-logout">
        <a href="admin_logout.php">Logout</a>
    </div>
</aside>
