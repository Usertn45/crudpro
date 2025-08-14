<?php
include 'db.php';

$userData = null;
$message = '';
$username = '';

// 1. If username is passed in the URL (from dashboard), fetch automatically
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $stmt = $conn->prepare("SELECT age, dob, gender, blood_group FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    if (!$userData) {
        $message = "Username not found.";
    }
    $stmt->close();
}

// 2. If form is posted for saving changes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $username = $_POST['username'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];

    $stmt = $conn->prepare("UPDATE users SET age=?, dob=?, gender=?, blood_group=? WHERE username=?");
    $stmt->bind_param("issss", $age, $dob, $gender, $blood_group, $username);
    if ($stmt->execute()) {
        $message = "✅ User updated successfully!";
    } else {
        $message = "❌ Error updating record: " . $conn->error;
    }
    $stmt->close();

    // Fetch updated data to show in form after save
    $stmt = $conn->prepare("SELECT age, dob, gender, blood_group FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
}
?>

<h2>Edit User</h2>
<?php if($message) echo "<p>$message</p>"; ?>

<form method="POST" action="">
  Username: 
  <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

  Age: 
  <input type="number" name="age" value="<?php echo $userData['age'] ?? ''; ?>"><br>
  Date of Birth: 
  <input type="date" name="dob" value="<?php echo $userData['dob'] ?? ''; ?>"><br>
  Gender:
  <select name="gender">
    <option value="">Select</option>
    <option value="Male" <?php if (($userData['gender'] ?? '') === 'Male') echo 'selected'; ?>>Male</option>
    <option value="Female" <?php if (($userData['gender'] ?? '') === 'Female') echo 'selected'; ?>>Female</option>
    <option value="Other" <?php if (($userData['gender'] ?? '') === 'Other') echo 'selected'; ?>>Other</option>
  </select><br>
  Blood Group: 
  <input type="text" name="blood_group" value="<?php echo $userData['blood_group'] ?? ''; ?>"><br><br>

  <button type="submit" name="save">Save</button>
</form>
