<?php
include 'db.php';

$message = '';

// If username is passed in URL (from dashboard link), delete directly
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // First check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the user
        $stmt_del = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt_del->bind_param("s", $username);
        if ($stmt_del->execute()) {
            $message = "✅ User '$username' deleted successfully.";
        } else {
            $message = "❌ Error deleting user: " . $conn->error;
        }
        $stmt_del->close();
    } else {
        $message = "⚠ Username not found.";
    }
    $stmt->close();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    // This handles manual deletion via form
    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt_del = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt_del->bind_param("s", $username);
        if ($stmt_del->execute()) {
            $message = "✅ User '$username' deleted successfully.";
        } else {
            $message = "❌ Error deleting user: " . $conn->error;
        }
        $stmt_del->close();
    } else {
        $message = "⚠ Username not found.";
    }
    $stmt->close();
}
?>

<h2>Delete User</h2>
<?php if($message) echo "<p>$message</p>"; ?>

<!-- Form for manual deletion -->
<form method="POST" action="">
  Username: <input type="text" name="username" required>
  <button type="submit" name="delete">Delete</button>
</form>
