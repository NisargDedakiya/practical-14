<?php
require_once "db.php";
require_once "functions.php";

admin_only();

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) die("User not found");

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $role = $_POST['role'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, role=?, status=? WHERE id=?");
    $stmt->execute([$username, $email, $role, $status, $id]);
    $message = "User updated successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit User</h2>
<form method="post">
    Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>
    Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
    Role:
    <select name="role">
        <option value="user" <?php if($user['role']=='user') echo 'selected'; ?>>User</option>
        <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
    </select><br><br>
    Status:
    <select name="status">
        <option value="active" <?php if($user['status']=='active') echo 'selected'; ?>>Active</option>
        <option value="inactive" <?php if($user['status']=='inactive') echo 'selected'; ?>>Inactive</option>
    </select><br><br>
    <button type="submit">Update</button>
</form>
<p><?php echo $message; ?></p>
<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
