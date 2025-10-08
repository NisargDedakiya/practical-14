<?php
require_once "db.php";
require_once "functions.php";

admin_only();

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
    header("Location: dashboard.php");
    exit;
}

// Fetch users
$stmt = $pdo->query("SELECT id, username, email, role, status, created_at FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
<?php foreach($users as $user): ?>
<tr>
    <td><?php echo $user['id']; ?></td>
    <td><?php echo $user['username']; ?></td>
    <td><?php echo $user['email']; ?></td>
    <td><?php echo $user['role']; ?></td>
    <td><?php echo $user['status']; ?></td>
    <td>
        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
        <a href="dashboard.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
